<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\RegistrationPackage;
use App\Models\Payment;

class UserController extends Controller
{
    /**
     * User Dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();

        return view('frontend.user.dashboard', compact('user'));
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
            //'last_name' => ['required', 'string', 'max:100'],

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