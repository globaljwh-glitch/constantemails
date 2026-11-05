<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RegistrationPackage;
use App\Models\Payment;
use App\Mail\PasswordChangedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\UserEmailUsage;

class UserController extends Controller
{
    /**
     * User Dashboard
     */
    // public function dashboard()
    // {
    //     $user = auth()->user();

    //     return view('frontend.user.dashboard', compact('user'));
    // }

    // public function dashboard()
    // {
    //     $user = auth()->user();

    //     // Get assigned package
    //     $package = DB::table('registration_packages')
    //         ->where('id', $user->package_id)
    //         ->where('status', 'Active')
    //         ->first();

    //     $contactLimit = (int) ($package->package_emails ?? 0);

    //     $uploadedContacts = DB::table('contact_lists')
    //         ->where('user_id', $user->id)
    //         ->count();

    //     $usage = UserEmailUsage::where('user_id', $user->id)
    //         ->where('period_started_at', '<=', now())
    //         ->where('period_ends_at', '>', now())
    //         ->latest('period_started_at')
    //         ->first();

    //     $emailsSent = (int) ($usage->emails_sent ?? 0);
    //     $emailsReserved = (int) ($usage->emails_reserved ?? 0);

    //     if ($contactLimit === -1) {
    //         $only_mail = -1;
    //         $contactPercentage = 0;
    //     } else {
    //         $only_mail = max(
    //             0,
    //             $contactLimit - $uploadedContacts - $emailsSent - $emailsReserved
    //         );

    //         $usedLimit = $uploadedContacts + $emailsSent + $emailsReserved;

    //         $contactPercentage = $contactLimit > 0
    //             ? min(100, ($usedLimit / $contactLimit) * 100)
    //             : 0;
    //     }

    //     return view('frontend.user.dashboard', compact(
    //         'user',
    //         'only_mail',
    //         'contactLimit',
    //         'uploadedContacts',
    //         'contactPercentage'
    //     ));
    // }

    // public function dashboard()
    // {
    //     $user = auth()->user();

    //     // Get assigned package
    //     $package = DB::table('registration_packages')
    //         ->where('id', $user->package_id)
    //         //->where('status', 'Active')
    //         ->first();

    //     $emailLimit = (int) ($package->package_emails ?? 0);

    //     // Get current monthly email usage
    //     $usage = UserEmailUsage::where('user_id', $user->id)
    //         ->where('period_started_at', '<=', now())
    //         ->where('period_ends_at', '>', now())
    //         ->latest('period_started_at')
    //         ->first();

    //     $emailsSent = (int) ($usage->emails_sent ?? 0);
    //     $emailsReserved = (int) ($usage->emails_reserved ?? 0);

    //     // Calculate remaining emails
    //     if ($emailLimit === -1) {
    //         $only_mail = -1;
    //         $emailPercentage = 0;
    //     } else {
    //         $only_mail = max(
    //             0,
    //             $emailLimit - $emailsSent - $emailsReserved
    //         );

    //         $usedLimit = $emailsSent + $emailsReserved;

    //         $emailPercentage = $emailLimit > 0
    //             ? min(100, ($usedLimit / $emailLimit) * 100)
    //             : 0;
    //     }

    //     return view('frontend.user.dashboard', compact(
    //         'user',
    //         'package',
    //         'only_mail',
    //         'emailLimit',
    //         'emailsSent',
    //         'emailsReserved',
    //         'emailPercentage'
    //     ));
    // }

    
    public function dashboard()
    {
        $user = auth()->user();

        // Get currently assigned package.
        $package = DB::table('registration_packages')
            ->where('id', $user->package_id)
            ->where('status', '!=', 'Deleted')
            ->first();

        $emailLimit = (int) ($package->package_emails ?? 0);

        // Get usage for the currently assigned package
        // and active billing period only.
        $usage = UserEmailUsage::where('user_id', $user->id)
            ->where('package_id', $user->package_id)
            ->where('period_started_at', '<=', now())
            ->where('period_ends_at', '>', now())
            ->latest('period_started_at')
            ->first();

        $emailsSent = (int) ($usage->emails_sent ?? 0);
        $emailsReserved = (int) ($usage->emails_reserved ?? 0);

        // Calculate remaining emails.
        if ($emailLimit === -1) {

            // Unlimited package.
            $only_mail = -1;
            $emailPercentage = 0;

        } else {

            $only_mail = max(
                0,
                $emailLimit - $emailsSent - $emailsReserved
            );

            $usedLimit = $emailsSent + $emailsReserved;

            $emailPercentage = $emailLimit > 0
                ? min(100, ($usedLimit / $emailLimit) * 100)
                : 0;
        }

        return view('frontend.user.dashboard', compact(
            'user',
            'package',
            'only_mail',
            'emailLimit',
            'emailsSent',
            'emailsReserved',
            'emailPercentage'
        ));
    }

    /**
     * Show Account Details / Edit Profile
     */
    public function profile()
    {
        $user = auth()->user();

        return view('frontend.user.account.details', compact('user'));
    }

    /**
     * Update Account Details
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],

            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'company_fax' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'zip' => ['nullable', 'string', 'max:20'],

            'billing_first_name' => ['nullable', 'string', 'max:100'],
            'billing_last_name' => ['nullable', 'string', 'max:100'],
            'billing_address' => ['nullable', 'string', 'max:500'],
            'billing_city' => ['nullable', 'string', 'max:100'],
            'billing_state' => ['nullable', 'string', 'max:100'],
            'billing_country' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('user.account.profile')
            ->with('success', 'Your account details have been successfully updated.');
    }

    /**
     * Billing Information
     */
    public function billing()
    {
        $user = auth()->user();

        return view('frontend.user.account.billing', compact('user'));
    }

    /**
     * Subscription
     */
    public function subscription()
    {
        $user = auth()->user();

        return view('frontend.user.account.subscription', compact('user'));
    }

    public function changePassword()
    {
        return view('frontend.user.account.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        \Log::info('Password change email sent', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);
        // Mail::to($user->email)->send(
        //     new PasswordChangedMail($user)
        // );

        // Send verification email using custom SMTP function
$toEmail = $user->email;
$fromEmail = env('MAIL_FROM_ADDRESS', config('mail.from.address'));
$subject = 'Your password has been changed';

// Render the existing verification email template
$body = View::make('emails.password-changed', [
    'user' => $user,
])->render();

// Send using your round-robin SMTP function
$this->send_smtp_mail(
    $toEmail,
    $fromEmail,
    $subject,
    $body
);

        // Mail::to($user->email)->queue(
        //     new PasswordChangedMail($user)
        // );


        return redirect()
            ->route('user.account.password')
            ->with('success', 'Your password has been successfully updated.');
    }

    public function upgradePackage()
    {
        $user = auth()->user();

        $packages = RegistrationPackage::where('status', 'Active')
            ->orderBy('package_price')
            ->get();

        return view('frontend.user.account.upgrade-package', compact(
            'user',
            'packages'
        ));
    }

    public function upgradePackageStore(Request $request)
    {
        $request->validate([
            'package_id' => ['required', 'exists:registration_packages,id'],
        ]);

        $package = RegistrationPackage::where('id', $request->package_id)
            ->where('status', 'Active')
            ->firstOrFail();

        /*
        * Stripe subscription upgrade will be handled here.
        */

        return redirect()
            ->route('user.account.upgrade')
            ->with(
                'success',
                'Package selected successfully. Stripe payment processing will be completed here.'
            );
    }

    public function paymentHistory()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->latest('payment_date')
            ->paginate(10);

        return view(
            'frontend.user.account.payment-history',
            compact('payments')
        );
    }
}