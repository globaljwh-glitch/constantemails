<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReferralController extends Controller
{
    /**
     * Show Refer a Friend page.
     */
    public function index()
    {
        $referrals = Referral::where('user_id', auth()->id())
            ->latest('submittedAt')
            ->get();

        return view(
            'frontend.user.referral',
            compact('referrals')
        );
    }


    /**
     * Submit referral.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'friend_name' => [
                'required',
                'string',
                'max:100',
            ],

            'refereEmail' => [
                'required',
                'email',
                'max:50',
            ],
        ]);


        $email = strtolower(trim($validated['refereEmail']));


        /*
        |--------------------------------------------------------------------------
        | Don't allow user to refer himself
        |--------------------------------------------------------------------------
        */

        if ($email === strtolower(auth()->user()->email)) {
            return back()
                ->withInput()
                ->withErrors([
                    'refereEmail' => 'You cannot refer your own email address.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Check whether this email already exists
        |--------------------------------------------------------------------------
        */

        $existingUser = User::whereRaw(
            'LOWER(email) = ?',
            [$email]
        )->first();


        if ($existingUser) {

            return back()
                ->withInput()
                ->withErrors([
                    'refereEmail' => 'This email address is already registered.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate referral
        |--------------------------------------------------------------------------
        */

        $alreadyReferred = Referral::where(
                'user_id',
                auth()->id()
            )
            ->whereRaw(
                'LOWER(refereEmail) = ?',
                [$email]
            )
            ->exists();


        if ($alreadyReferred) {

            return back()
                ->withInput()
                ->withErrors([
                    'refereEmail' => 'You have already referred this email address.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Save referral
        |--------------------------------------------------------------------------
        */

        $referral = Referral::create([
            'user_id'          => auth()->id(),
            'submittedAt'      => now(),
            'refereEmail'      => $email,
            'referred_user_id' => 0,
            'Status'           => 0,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Send referral email
        |--------------------------------------------------------------------------
        */

        try {

            Mail::send(
                'emails.referral',
                [
                    'referral'  => $referral,
                    'friendName' => $validated['friend_name'],
                    'sender'    => auth()->user(),
                ],
                function ($message) use ($email, $validated) {

                    $message->to(
                        $email,
                        $validated['friend_name']
                    )->subject(
                        auth()->user()->name . ' invited you to Constant Emails'
                    );
                }
            );

        } catch (\Throwable $e) {

            \Log::error('Referral email failed', [
                'referral_id' => $referral->id,
                'email'       => $email,
                'error'       => $e->getMessage(),
            ]);

            return redirect()
                ->route('user.referral')
                ->with(
                    'warning',
                    'Your referral was saved, but the invitation email could not be sent.'
                );
        }


        return redirect()
            ->route('user.referral')
            ->with(
                'success',
                'Your referral invitation has been sent successfully.'
            );
    }
}