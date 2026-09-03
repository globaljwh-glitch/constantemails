<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display Login Form
     */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Login User
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            if (! Auth::user()->is_admin) {

                Auth::logout();

                return back()->withErrors([
                    'email' => 'You are not authorized to access the admin panel.',
                ]);
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    /**
     * Logout User
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    /**
     * Forgot Password Form
     */
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Send Reset Link
     */
    public function sendResetLink(Request $request)
    {
        //
    }

    /**
     * Reset Password Form
     */
    public function showResetPassword(string $token)
    {
        return view('admin.auth.reset-password', compact('token'));
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        //
    }
}