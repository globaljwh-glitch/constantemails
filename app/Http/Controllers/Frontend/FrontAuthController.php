<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\View;

class FrontAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Authentication Views
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    public function showRegister()
    {
        $packages = RegistrationPackage::where('status', 'Active')
            ->orderBy('package_price')
            ->get();

        return view('frontend.auth.register', compact('packages'));
    }

    public function showForgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    public function showResetPassword(string $token)
    {
        return view('frontend.auth.reset-password', compact('token'));
    }

    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        $request->validate([
            //'username'   => 'required|string|max:100|unique:users,username',
            'username'   => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'company_phone' => 'required|string|max:100',
            'company_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            'package_id' => 'required|exists:registration_packages,id',
            'terms'      => 'accepted',
        ]);

        DB::beginTransaction();

        try {

            $package = RegistrationPackage::findOrFail($request->package_id);

            // Generate email verification token
            $verificationToken = Str::random(64);

            $user = User::create([
                'name'              => ucfirst($request->username),
                'last_name'         => ucfirst($request->last_name),
                'username'          => $request->username,
                'email'             => $request->email,
                'company_name'      => $request->company_name,
                'comapny_phone'     => $request->comapny_phone,
                'password'          => Hash::make($request->password),
                'package_id'        => $package->id,
                'status'            => 'Deactive',
                'is_admin'          => 0,
                'verification_token'=> $verificationToken,
                'email_verified_at' => null,
            ]);

            DB::commit();

            // Send verification email
            // Mail::to($user->email)->send(
            //     new VerifyEmailMail($user)
            // );
            // Send verification email using custom SMTP function



            // $mail = new VerifyEmailMail($user);

            // $fromEmail = config('mail.from.address');
            // $toEmail = $user->email;
            // $subject = 'Verify Your Email';
            // //$subject = $mail->envelope()->subject;

            // // Render the email HTML
            // $body = $mail->content()->view
            //     ? view($mail->content()->view, $mail->content()->with)->render()
            //     : '';

            // $this->send_smtp_mail(
            //     $toEmail,
            //     $fromEmail,
            //     $subject,
            //     $body
            // );

            // Send verification email using custom SMTP function
            $toEmail = $user->email;
            $fromEmail = env('MAIL_FROM_ADDRESS', config('mail.from.address'));
            $subject = 'Verify Your Email Address';

            // Render the existing verification email template
            $body = View::make('emails.verify-email', [
                'user' => $user,
            ])->render();

            // Send using your round-robin SMTP function
            $this->send_smtp_mail(
                $toEmail,
                $fromEmail,
                $subject,
                $body
            );

            return redirect()
                ->route('register')
                ->with(
                    'success',
                    'Registration completed successfully. Please check your email and verify your account before login.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
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

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string|max:100|unique:users,username',
    //         'email' => 'required|email|max:255|unique:users,email',
    //         'password' => 'required|min:8|confirmed',
    //         'package_id' => 'required|exists:registration_packages,id',
    //         'terms' => 'accepted',
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         $package = RegistrationPackage::findOrFail($request->package_id);

    //         User::create([
    //             'name' => ucfirst($request->username),
    //             'username' => $request->username,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //             'package_id' => $package->id,
    //             'status' => 'Deactive',
    //             'is_admin' => 0,
    //         ]);

    //         DB::commit();

    //         return redirect()
    //             ->route('register')
    //             ->with('success', 'Registration completed successfully. Please login.');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()
    //             ->withInput()
    //             ->with('error', $e->getMessage());
    //     }
    // }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => 0, // Only frontend users
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();

        if ($user->status !== 'Active') {

            Auth::logout();

            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Your account is not active. Please verify your email first.');
        }

        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    */

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {

            return back()->with(
                'status',
                'Password reset link has been sent to your email address.'
            );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => __($status),
            ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with('status', 'Your password has been reset successfully.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => __($status),
            ]);
    }

    public function verifyEmail(string $token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Invalid verification link.',
                ]);
        }

        if (
            $user->verification_expires_at &&
            $user->verification_expires_at->isPast()
        ) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'This verification link has expired.',
                ]);
        }

        $user->update([
            'status' => 'Active',
            'email_verified_at' => now(),
            'verification_token' => null,
            'verification_expires_at' => null,
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Your email has been verified successfully. You can now login.');
    }
}