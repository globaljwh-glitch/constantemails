<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use App\Models\User;
use App\Models\RegistrationPackage;
use App\Models\UserPackage;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Authentication Views
    |--------------------------------------------------------------------------
    */

    /**
     * Home Login Page
     */
    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    /**
     * Registration Page
     */
    public function showRegister()
    {
        $packages = RegistrationPackage::where('status', 'Active')
            ->orderBy('package_price')
            ->get();

        return view('frontend.auth.register', compact('packages'));
    }

    /**
     * Forgot Password Page
     */
    public function showForgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * Reset Password Page
     */
    public function showResetPassword(string $token)
    {
        return view('frontend.auth.reset-password', [
            'token' => $token
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    /**
     * Login User
     */
    public function login(Request $request)
    {
        //
    }

    /**
     * Register User
     */
    public function register(Request $request)
    {
        //
    }

    /**
     * Logout
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
    | Password Reset
    |--------------------------------------------------------------------------
    */

    /**
     * Send Password Reset Link
     */
    public function sendResetLink(Request $request)
    {
        //
    }

    /**
     * Update Password
     */
    public function resetPassword(Request $request)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    */

    /**
     * Verify Email
     */
    public function verifyEmail(Request $request)
    {
        //
    }

    /**
     * Resend Verification Email
     */
    public function resendVerification(Request $request)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Stripe Subscription
    |--------------------------------------------------------------------------
    */

    /**
     * Stripe Checkout
     */
    public function stripeCheckout(Request $request)
    {
        //
    }

    /**
     * Stripe Success
     */
    public function stripeSuccess(Request $request)
    {
        //
    }

    /**
     * Stripe Cancel
     */
    public function stripeCancel()
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Subscription
    |--------------------------------------------------------------------------
    */

    /**
     * Upgrade Package
     */
    public function upgradePackage(Request $request)
    {
        //
    }

    /**
     * Downgrade Package
     */
    public function downgradePackage(Request $request)
    {
        //
    }

    /**
     * Cancel Subscription
     */
    public function cancelSubscription(Request $request)
    {
        //
    }

    /**
     * Resume Subscription
     */
    public function resumeSubscription(Request $request)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------
    */

    /**
     * Dashboard
     */
    public function dashboard()
    {
        //
    }

    /**
     * User Profile
     */
    public function profile()
    {
        //
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        //
    }

    /**
     * Change Password
     */
    public function changePassword(Request $request)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Billing
    |--------------------------------------------------------------------------
    */

    /**
     * Billing History
     */
    public function billingHistory()
    {
        //
    }

    /**
     * Payment History
     */
    public function paymentHistory()
    {
        //
    }

    /**
     * Download Invoice
     */
    public function downloadInvoice($invoiceId)
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Create User Package
     */
    protected function createUserPackage(User $user, RegistrationPackage $package)
    {
        //
    }

    /**
     * Save Payment
     */
    protected function savePayment(array $paymentData)
    {
        //
    }
}