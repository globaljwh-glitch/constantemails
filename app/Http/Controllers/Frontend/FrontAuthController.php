<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'package_id' => 'required|exists:registration_packages,id',
            'terms' => 'accepted',
        ]);

        DB::beginTransaction();

        try {

            $package = RegistrationPackage::findOrFail($request->package_id);

            User::create([
                'name' => ucfirst($request->username),
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'package_id' => $package->id,
                'status' => 'Active',
                'is_admin' => 0,
            ]);

            DB::commit();

            return redirect()
                ->route('register')
                ->with('success', 'Registration completed successfully. Please login.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

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
//         dd([
//     'email'    => auth()->user()->email,
//     'is_admin' => auth()->user()->is_admin,
// ]);

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
        //
    }

    public function resetPassword(Request $request)
    {
        //
    }
}