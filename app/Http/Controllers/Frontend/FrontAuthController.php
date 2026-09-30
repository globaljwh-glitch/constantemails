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
            'username'   => 'required|string|max:100|unique:users,username',
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
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'package_id'        => $package->id,
                'status'            => 'Deactive',
                'is_admin'          => 0,
                'verification_token'=> $verificationToken,
                'email_verified_at' => null,
            ]);

            DB::commit();

            // Send verification email
            Mail::to($user->email)->send(
                new VerifyEmailMail($user)
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
        $user = Auth::user();
        if ($user->status !== 'Active') {

            Auth::logout();

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Please verify your email address before logging in.',
                ]);
        }

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