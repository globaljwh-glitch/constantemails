<?php

namespace App\Services;

use App\Models\EmailVerification;
use Illuminate\Support\Facades\Log;

class EmailVerifier
{
    protected int $timeout;

    protected string $from;

    protected string $helo;

    public function __construct()
    {
        $this->timeout = (int) config(
            'email_verification.timeout',
            10
        );

        $this->from = config(
            'email_verification.from'
        );

        $this->helo = config(
            'email_verification.helo'
        );
    }

    /**
     * Verify an email address.
     */
    public function verify(
        string $email,
        bool $force = false
    ): EmailVerification {

        $email = strtolower(trim($email));

        /*
        |--------------------------------------------------------------------------
        | Existing cached result
        |--------------------------------------------------------------------------
        */

        if (!$force) {

            $existing = EmailVerification::where(
                'email',
                $email
            )->first();

            if (
                $existing &&
                $existing->verified_at &&
                $existing->verified_at->gt(
                    now()->subMinutes(
                        config(
                            'email_verification.cache_minutes',
                            10080
                        )
                    )
                )
            ) {
                return $existing;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Create / update record
        |--------------------------------------------------------------------------
        */

        $verification = EmailVerification::firstOrNew([
            'email' => $email,
        ]);

        $verification->domain = null;
        $verification->status = 'unknown';
        $verification->smtp_status = 'not_checked';
        $verification->syntax_valid = false;
        $verification->domain_exists = false;
        $verification->mx_exists = false;
        $verification->mx_host = null;
        $verification->smtp_code = null;
        $verification->message = null;
        $verification->verified_at = null;

        /*
        |--------------------------------------------------------------------------
        | 1. Syntax validation
        |--------------------------------------------------------------------------
        */

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $verification->status = 'invalid';
            $verification->smtp_status = 'not_checked';
            $verification->message = 'Invalid email syntax';
            $verification->verified_at = now();

            $verification->save();

            return $verification;
        }

        $verification->syntax_valid = true;

        /*
        |--------------------------------------------------------------------------
        | Extract domain
        |--------------------------------------------------------------------------
        */

        $parts = explode('@', $email);

        if (count($parts) !== 2) {

            $verification->status = 'invalid';
            $verification->message = 'Invalid email format';
            $verification->verified_at = now();

            $verification->save();

            return $verification;
        }

        $domain = strtolower(trim($parts[1]));

        $verification->domain = $domain;

        /*
        |--------------------------------------------------------------------------
        | 2. Check domain
        |--------------------------------------------------------------------------
        */

        if (
            !checkdnsrr($domain, 'A') &&
            !checkdnsrr($domain, 'AAAA') &&
            !checkdnsrr($domain, 'MX')
        ) {

            $verification->domain_exists = false;
            $verification->status = 'invalid';
            $verification->message = 'Domain does not resolve';
            $verification->verified_at = now();

            $verification->save();

            return $verification;
        }

        $verification->domain_exists = true;

        /*
        |--------------------------------------------------------------------------
        | 3. MX records
        |--------------------------------------------------------------------------
        */

        $mxRecords = [];

        $mxWeights = [];

        if (!getmxrr(
            $domain,
            $mxRecords,
            $mxWeights
        )) {

            $verification->mx_exists = false;
            $verification->status = 'invalid';
            $verification->message = 'No MX record found';
            $verification->verified_at = now();

            $verification->save();

            return $verification;
        }

        $verification->mx_exists = true;

        /*
        |--------------------------------------------------------------------------
        | Sort MX records by priority
        |--------------------------------------------------------------------------
        */

        $records = [];

        foreach ($mxRecords as $index => $host) {

            $records[] = [
                'host' => $host,
                'priority' => $mxWeights[$index] ?? 0,
            ];
        }

        usort(
            $records,
            fn ($a, $b) =>
                $a['priority'] <=> $b['priority']
        );

        /*
        |--------------------------------------------------------------------------
        | 4. SMTP verification
        |--------------------------------------------------------------------------
        */

        $attempted = 0;

        foreach ($records as $record) {

            if (
                $attempted >= config(
                    'email_verification.max_mx_hosts',
                    3
                )
            ) {
                break;
            }

            $attempted++;

            $result = $this->checkSmtp(
                $record['host'],
                $email
            );

            if (!$result) {
                continue;
            }

            $verification->mx_host =
                $record['host'];

            $verification->smtp_status =
                $result['status'];

            $verification->smtp_code =
                $result['code'];

            $verification->message =
                $result['message'];

            /*
            |--------------------------------------------------------------------------
            | Permanent rejection
            |--------------------------------------------------------------------------
            */

            if ($result['status'] === 'rejected') {

                $verification->status = 'invalid';

                break;
            }

            /*
            |--------------------------------------------------------------------------
            | Accepted
            |--------------------------------------------------------------------------
            */

            if ($result['status'] === 'accepted') {

                $verification->status = 'valid';

                break;
            }

            /*
            |--------------------------------------------------------------------------
            | Temporary / blocked / unknown
            |--------------------------------------------------------------------------
            */

            $verification->status = 'unknown';
        }

        /*
        |--------------------------------------------------------------------------
        | If no MX server could be contacted
        |--------------------------------------------------------------------------
        */

        if ($verification->smtp_status === 'not_checked') {

            $verification->smtp_status =
                'connection_failed';

            $verification->status =
                'unknown';

            $verification->message =
                'Could not connect to MX server';
        }

        $verification->verified_at = now();

        $verification->save();

        return $verification;
    }

    /**
     * Perform SMTP recipient verification.
     */
    protected function checkSmtp(
        string $host,
        string $email
    ): ?array {

        $errno = 0;
        $errstr = '';

        /*
        |--------------------------------------------------------------------------
        | Connect to SMTP server
        |--------------------------------------------------------------------------
        */

        $socket = @fsockopen(
            $host,
            25,
            $errno,
            $errstr,
            $this->timeout
        );

        if (!$socket) {

            Log::warning(
                'SMTP verification connection failed',
                [
                    'host' => $host,
                    'email' => $email,
                    'error' => $errstr,
                    'errno' => $errno,
                ]
            );

            return [
                'status' => 'connection_failed',
                'code' => null,
                'message' =>
                    "Connection failed: {$errstr}",
            ];
        }

        stream_set_timeout(
            $socket,
            $this->timeout
        );

        /*
        |--------------------------------------------------------------------------
        | SMTP greeting
        |--------------------------------------------------------------------------
        */

        $response = $this->readResponse(
            $socket
        );

        if (!$response) {

            fclose($socket);

            return [
                'status' => 'timeout',
                'code' => null,
                'message' =>
                    'No SMTP greeting received',
            ];
        }

        $code = $this->getCode($response);

        if ($code < 200 || $code >= 400) {

            fclose($socket);

            return [
                'status' => 'unknown',
                'code' => $code,
                'message' => trim($response),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | EHLO
        |--------------------------------------------------------------------------
        */

        fwrite(
            $socket,
            "EHLO {$this->helo}\r\n"
        );

        $response = $this->readResponse(
            $socket
        );

        $code = $this->getCode($response);

        if ($code < 200 || $code >= 400) {

            /*
            | Try HELO if EHLO failed.
            */

            fwrite(
                $socket,
                "HELO {$this->helo}\r\n"
            );

            $response = $this->readResponse(
                $socket
            );

            $code = $this->getCode($response);

            if ($code < 200 || $code >= 400) {

                fwrite(
                    $socket,
                    "QUIT\r\n"
                );

                fclose($socket);

                return [
                    'status' => 'unknown',
                    'code' => $code,
                    'message' => trim($response),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MAIL FROM
        |--------------------------------------------------------------------------
        */

        fwrite(
            $socket,
            "MAIL FROM:<{$this->from}>\r\n"
        );

        $response = $this->readResponse(
            $socket
        );

        $code = $this->getCode($response);

        /*
        |--------------------------------------------------------------------------
        | MAIL FROM rejected
        |--------------------------------------------------------------------------
        */

        if ($code >= 500) {

            fwrite(
                $socket,
                "QUIT\r\n"
            );

            fclose($socket);

            return [
                'status' => 'unknown',
                'code' => $code,
                'message' =>
                    'MAIL FROM rejected: ' .
                    trim($response),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RCPT TO
        |--------------------------------------------------------------------------
        */

        fwrite(
            $socket,
            "RCPT TO:<{$email}>\r\n"
        );

        $response = $this->readResponse(
            $socket
        );

        $code = $this->getCode($response);

        /*
        |--------------------------------------------------------------------------
        | QUIT
        |--------------------------------------------------------------------------
        */

        fwrite(
            $socket,
            "QUIT\r\n"
        );

        fclose($socket);

        /*
        |--------------------------------------------------------------------------
        | Interpret SMTP response
        |--------------------------------------------------------------------------
        */

        if ($code >= 200 && $code < 300) {

            return [
                'status' => 'accepted',
                'code' => $code,
                'message' => trim($response),
            ];
        }

        /*
        | 4xx = temporary
        */

        if ($code >= 400 && $code < 500) {

            return [
                'status' => 'temporary',
                'code' => $code,
                'message' => trim($response),
            ];
        }

        /*
        | 5xx = rejected
        */

        if ($code >= 500) {

            return [
                'status' => 'rejected',
                'code' => $code,
                'message' => trim($response),
            ];
        }

        return [
            'status' => 'unknown',
            'code' => $code,
            'message' => trim($response),
        ];
    }

    /**
     * Read SMTP multiline response.
     */
    protected function readResponse($socket): string
    {
        $response = '';

        while (!feof($socket)) {

            $line = fgets(
                $socket,
                512
            );

            if ($line === false) {
                break;
            }

            $response .= $line;

            /*
            | SMTP multiline responses look like:
            |
            | 250-example.com
            | 250-SIZE 52428800
            | 250 OK
            |
            | Final line contains "250 " instead of "250-".
            */

            if (
                preg_match(
                    '/^\d{3}\s/',
                    $line
                )
            ) {
                break;
            }
        }

        return $response;
    }

    /**
     * Extract SMTP status code.
     */
    protected function getCode(
        ?string $response
    ): int {

        if (!$response) {
            return 0;
        }

        if (
            preg_match(
                '/^(\d{3})/',
                trim($response),
                $matches
            )
        ) {
            return (int) $matches[1];
        }

        return 0;
    }
}