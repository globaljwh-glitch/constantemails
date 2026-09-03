<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Split name for the form
        $nameParts = explode(' ', $user->name, 2);
        $user->first_name = $nameParts[0] ?? '';
        $user->last_name = $nameParts[1] ?? '';

        return view('admin.auth.user_profile', compact('user'));
    }

    public function updateDetails(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        try {
            $user->name = $request->first_name . ' ' . $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            return redirect()->back()->with('success', 'Profile details updated successfully!');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while updating details.');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password does not match!');
        }

        try {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            Log::error('Password update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while updating password.');
        }
    }
}
