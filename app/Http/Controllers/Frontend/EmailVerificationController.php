<?php

namespace App\Http\Controllers;

use App\Services\EmailVerifier;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(
        Request $request,
        EmailVerifier $verifier
    ) {
        $request->validate([
            'email' => [
                'required',
                'email',
                'max:254',
            ],
        ]);

        $result = $verifier->verify(
            $request->email
        );

        return response()->json([
            'email' => $result->email,
            'status' => $result->status,
            'smtp_status' => $result->smtp_status,
            'syntax_valid' => $result->syntax_valid,
            'domain_exists' => $result->domain_exists,
            'mx_exists' => $result->mx_exists,
            'smtp_code' => $result->smtp_code,
            'message' => $result->message,
            'verified_at' => $result->verified_at,
        ]);
    }
}