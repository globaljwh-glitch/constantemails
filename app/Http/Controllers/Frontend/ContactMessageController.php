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

            $adminEmail = config(
                'mail.contact_email',
                env('MAIL_FROM_ADDRESS', config('mail.from.address'))
            );

            Mail::send(
                'emails.contact-admin',
                [
                    'contact' => $contactMessage,
                ],
                function ($message) use ($adminEmail, $contactMessage) {

                    $message->to($adminEmail)
                        ->replyTo(
                            $contactMessage->email,
                            trim(
                                $contactMessage->first_name . ' ' .
                                ($contactMessage->last_name ?? '')
                            )
                        )
                        ->subject(
                            'New Contact Us Message - ' .
                            $contactMessage->first_name
                        );
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Confirmation email to visitor
            |--------------------------------------------------------------------------
            */

            Mail::send(
                'emails.contact-confirmation',
                [
                    'contact' => $contactMessage,
                ],
                function ($message) use ($contactMessage) {

                    $message->to(
                        $contactMessage->email,
                        trim(
                            $contactMessage->first_name . ' ' .
                            ($contactMessage->last_name ?? '')
                        )
                    )->subject(
                        'Thank you for contacting Constant Emails'
                    );
                }
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
}