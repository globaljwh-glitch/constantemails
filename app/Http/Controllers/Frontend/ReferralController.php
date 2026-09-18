<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        return view('frontend.user.referral');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'friend_name' => [
                'required',
                'string',
                'max:50',
            ],

            'friend_email' => [
                'required',
                'email',
                'max:100',
            ],
        ]);

        // Referral processing will go here.

        return redirect()
            ->route('user.referral')
            ->with(
                'success',
                'Thank you! Your referral has been submitted successfully.'
            );
    }
}