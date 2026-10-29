<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    /**
     * Display contact page.
     */
    public function index()
    {
        return view('frontend.pages.contact');
    }

    /**
     * Store contact message and send emails.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'organization' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'comments' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Save message
        |--------------------------------------------------------------------------
        */

        $contactMessage = ContactMessage::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'] ?? null,
            'email'        => $validated['email'],
            'organization' => $validated['organization'] ?? null,
            'phone'        => $validated['phone'] ?? null,
            'comments'     => $validated['comments'],
            'status'       => 'new',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send email to Constant Emails
        |--------------------------------------------------------------------------
        */

        try {

            // $adminEmail = config(
            //     'mail.contact_email',
            //     env('MAIL_FROM_ADDRESS', config('mail.from.address'))
            // );

            // Mail::send(
            //     'emails.contact-admin',
            //     [
            //         'contact' => $contactMessage,
            //     ],
            //     function ($message) use ($adminEmail, $contactMessage) {

            //         $message->to($adminEmail)
            //             ->replyTo(
            //                 $contactMessage->email,
            //                 trim(
            //                     $contactMessage->first_name . ' ' .
            //                     ($contactMessage->last_name ?? '')
            //                 )
            //             )
            //             ->subject(
            //                 'New Contact Us Message - ' .
            //                 $contactMessage->first_name
            //             );
            //     }
            // );


            /*
            |--------------------------------------------------------------------------
            | Confirmation email to visitor
            |--------------------------------------------------------------------------
            */

            // Mail::send(
            //     'emails.contact-confirmation',
            //     [
            //         'contact' => $contactMessage,
            //     ],
            //     function ($message) use ($contactMessage) {

            //         $message->to(
            //             $contactMessage->email,
            //             trim(
            //                 $contactMessage->first_name . ' ' .
            //                 ($contactMessage->last_name ?? '')
            //             )
            //         )->subject(
            //             'Thank you for contacting Constant Emails'
            //         );
            //     }
            // );

            
            $adminEmail = config(
                'mail.contact_email',
                env('MAIL_FROM_ADDRESS', config('mail.from.address'))
            );

            $fromEmail = env('MAIL_FROM_ADDRESS', config('mail.from.address'));

            // Email 1: Notify admin about the contact form submission
            $adminSubject = 'New Contact Us Message - ' .
                $contactMessage->first_name;

            $adminBody = view('emails.contact-admin', [
                'contact' => $contactMessage,
            ])->render();

            $this->send_smtp_mail(
                $adminEmail,
                $fromEmail,
                $adminSubject,
                $adminBody,
                null,
                $contactMessage->email
            );


            // Email 2: Send confirmation to the visitor
            $visitorName = trim(
                $contactMessage->first_name . ' ' .
                ($contactMessage->last_name ?? '')
            );

            $visitorSubject = 'Thank you for contacting Constant Emails';

            $visitorBody = view('emails.contact-confirmation', [
                'contact' => $contactMessage,
            ])->render();

            $this->send_smtp_mail(
                $contactMessage->email,
                $fromEmail,
                $visitorSubject,
                $visitorBody
            );


        } catch (\Throwable $e) {

            /*
             * The contact message has already been saved.
             * Log the email error instead of losing the inquiry.
             */

            Log::error('Contact email failed', [
                'contact_message_id' => $contactMessage->id,
                'email' => $contactMessage->email,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('contact')
                ->withInput()
                ->with(
                    'warning',
                    'Your message was saved successfully, but we could not send the confirmation email right now.'
                );
        }


        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Thank you for contacting us! Your message has been sent successfully. We will get back to you within 24 to 48 hours.'
            );
    }

    public function send_smtp_mail(
    $to,
    $from,
    $subject,
    $body,
    $attachmentPath = null
    ) {
        // $smtpServer = '10.1.14.11';
        // $smtpPort   = 25;
        $smtpServers = config('mail.smtp_servers', ['10.1.14.11']);

        if (empty($smtpServers)) {
            throw new \RuntimeException('No SMTP servers configured.');
        }

        // Randomly select an SMTP server for this email
        $smtpServer = $smtpServers[array_rand($smtpServers)];

        $smtpPort = (int) config('mail.mailers.smtp.port', 25);

        $errno  = 0;
        $errstr = '';

        $fp = fsockopen(
            $smtpServer,
            $smtpPort,
            $errno,
            $errstr,
            10
        );

        if (!$fp) {
            throw new \Exception(
                "SMTP connection failed: {$errstr} ({$errno})"
            );
        }

        stream_set_timeout($fp, 30);

        /*
        |--------------------------------------------------------------------------
        | Read SMTP response
        |--------------------------------------------------------------------------
        */
        $readResponse = function () use ($fp) {

            $response = '';

            while (($line = fgets($fp, 515)) !== false) {

                $response .= $line;

                // End of multiline SMTP response
                if (isset($line[3]) && $line[3] === ' ') {
                    break;
                }
            }

            return $response;
        };

        /*
        |--------------------------------------------------------------------------
        | Send SMTP command
        |--------------------------------------------------------------------------
        */
        $sendCommand = function ($command) use ($fp, $readResponse) {

            fwrite($fp, $command . "\r\n");

            return $readResponse();
        };

        /*
        |--------------------------------------------------------------------------
        | SMTP Greeting
        |--------------------------------------------------------------------------
        */
        $response = $readResponse();

        if (substr($response, 0, 1) !== '2') {

            fclose($fp);

            throw new \Exception(
                "SMTP greeting failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | HELO
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand(
            'HELO constantemails.com'
        );

        if (substr($response, 0, 3) !== '250') {

            fclose($fp);

            throw new \Exception(
                "SMTP HELO failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MAIL FROM
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand(
            "MAIL FROM:<{$from}>"
        );

        if (substr($response, 0, 3) !== '250') {

            fclose($fp);

            throw new \Exception(
                "SMTP MAIL FROM failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RCPT TO
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand(
            "RCPT TO:<{$to}>"
        );

        if (
            substr($response, 0, 3) !== '250' &&
            substr($response, 0, 3) !== '251'
        ) {

            fclose($fp);

            throw new \Exception(
                "SMTP RCPT TO failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand('DATA');

        if (substr($response, 0, 3) !== '354') {

            fclose($fp);

            throw new \Exception(
                "SMTP DATA failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MIME Boundary
        |--------------------------------------------------------------------------
        */
        $boundary = '=_ConstantEmails_' . md5(
            uniqid((string) mt_rand(), true)
        );

        /*
        |--------------------------------------------------------------------------
        | Email Headers
        |--------------------------------------------------------------------------
        */
        $message  = "Date: " . date('r') . "\r\n";
        $message .= "From: {$from}\r\n";
        $message .= "To: {$to}\r\n";
        $message .= "Subject: {$subject}\r\n";
        $message .= "MIME-Version: 1.0\r\n";

        /*
        |--------------------------------------------------------------------------
        | Attachment
        |--------------------------------------------------------------------------
        */
        if ($attachmentPath && file_exists($attachmentPath)) {

            $fileName = basename($attachmentPath);

            $mimeType = mime_content_type($attachmentPath);

            if (!$mimeType) {
                $mimeType = 'application/octet-stream';
            }

            $message .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";
            $message .= "\r\n";

            /*
            |--------------------------------------------------------------------------
            | HTML Body
            |--------------------------------------------------------------------------
            */
            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n";
            $message .= "\r\n";

            // Prevent SMTP termination issues
            $body = str_replace(
                ["\r\n.", "\n."],
                ["\r\n..", "\n.."],
                $body
            );

            $message .= $body;
            $message .= "\r\n";

            /*
            |--------------------------------------------------------------------------
            | Attachment
            |--------------------------------------------------------------------------
            */
            $fileContent = file_get_contents($attachmentPath);

            if ($fileContent === false) {

                fclose($fp);

                throw new \Exception(
                    "Unable to read attachment: {$attachmentPath}"
                );
            }

            $encodedFile = chunk_split(
                base64_encode($fileContent),
                76,
                "\r\n"
            );

            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: {$mimeType}; name=\"{$fileName}\"\r\n";
            $message .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "\r\n";
            $message .= $encodedFile;
            $message .= "\r\n";

            /*
            |--------------------------------------------------------------------------
            | End MIME
            |--------------------------------------------------------------------------
            */
            $message .= "--{$boundary}--\r\n";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Normal HTML Email Without Attachment
            |--------------------------------------------------------------------------
            */
            $message .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n";
            $message .= "\r\n";

            $body = str_replace(
                ["\r\n.", "\n."],
                ["\r\n..", "\n.."],
                $body
            );

            $message .= $body;
            $message .= "\r\n";
        }

        /*
        |--------------------------------------------------------------------------
        | SMTP End of DATA
        |--------------------------------------------------------------------------
        */
        $message .= ".\r\n";

        fwrite($fp, $message);

        /*
        |--------------------------------------------------------------------------
        | SMTP Response
        |--------------------------------------------------------------------------
        */
        $response = $readResponse();

        if (substr($response, 0, 3) !== '250') {

            fclose($fp);

            throw new \Exception(
                "SMTP message rejected: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | QUIT
        |--------------------------------------------------------------------------
        */
        fwrite($fp, "QUIT\r\n");

        $readResponse();

        fclose($fp);

        return true;
    }
}