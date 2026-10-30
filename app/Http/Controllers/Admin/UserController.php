<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationPackage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('package')->where('is_admin', 0);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $packages = RegistrationPackage::where('status', 'Active')->get();
        return view('admin.users.form', compact('packages'));
    }

    public function store(Request $request)
    {
        $messages = [
            'username.required' => 'Please enter a unique username.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'A valid email address is required.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please provide a secure password.',
            'password.min' => 'Password must be at least 6 characters long.',
            'first_name.required' => 'First name is mandatory.',
            'last_name.required' => 'Last name is mandatory.',
            'package_id.required' => 'Please choose a valid subscription package.',
            'package_id.exists' => 'Selected package does not exist.',
            'status.required' => 'Account status is required.'
        ];

        $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'status' => 'required|in:Active,Deactive',
            'package_id' => 'required|exists:registration_packages,id',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:200',
            'country' => 'nullable|string|max:200',
            'zip' => 'nullable|string|max:20',
            'company_phone' => 'nullable|string|max:20',
            'company_fax' => 'nullable|string|max:20',
            'billing_first_name' => 'nullable|string|max:200',
            'billing_last_name' => 'nullable|string|max:200',
            'billing_address' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:200',
            'billing_country' => 'nullable|string|max:200',
            'billing_zip' => 'nullable|string|max:6',
            'additional_details' => 'nullable|string',
            'masking_allowed' => 'required|boolean',
        ], $messages);

        try {
            $data = $request->only([
                'username',
                'email',
                'last_name',
                'company_name',
                'company_address',
                'city',
                'state',
                'country',
                'zip',
                'company_phone',
                'company_fax',
                'billing_first_name',
                'billing_last_name',
                'billing_address',
                'billing_city',
                'billing_state',
                'billing_country',
                'billing_zip',
                'package_id',
                'additional_details',
                'masking_allowed',
                'status'
            ]);

            // Map form's 'first_name' directly to the database 'name' column
            $data['name'] = $request->first_name;
            $data['password'] = Hash::make($request->password);
            $data['account_type'] = 'user';

            User::create($data);
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $packages = RegistrationPackage::where('status', 'Active')->get();

        // Map database 'name' column back to form's 'first_name' field for editing
        $user->first_name = $user->name;

        return view('admin.users.form', compact('user', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $messages = [
            'username.required' => 'Please enter a unique username.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'A valid email address is required.',
            'email.unique' => 'This email address is already registered.',
            'password.min' => 'Password must be at least 6 characters long.',
            'first_name.required' => 'First name is mandatory.',
            'last_name.required' => 'Last name is mandatory.',
            'package_id.required' => 'Please choose a valid subscription package.',
            'package_id.exists' => 'Selected package does not exist.',
            'status.required' => 'Account status is required.'
        ];

        $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'status' => 'required|in:Active,Deactive',
            'package_id' => 'required|exists:registration_packages,id',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:200',
            'country' => 'nullable|string|max:200',
            'zip' => 'nullable|string|max:20',
            'company_phone' => 'nullable|string|max:20',
            'company_fax' => 'nullable|string|max:20',
            'billing_first_name' => 'nullable|string|max:200',
            'billing_last_name' => 'nullable|string|max:200',
            'billing_address' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:200',
            'billing_country' => 'nullable|string|max:200',
            'billing_zip' => 'nullable|string|max:6',
            'additional_details' => 'nullable|string',
            'masking_allowed' => 'required|boolean',
        ], $messages);

        try {
            $data = $request->only([
                'username',
                'email',
                'last_name',
                'company_name',
                'company_address',
                'city',
                'state',
                'country',
                'zip',
                'company_phone',
                'company_fax',
                'billing_first_name',
                'billing_last_name',
                'billing_address',
                'billing_city',
                'billing_state',
                'billing_country',
                'billing_zip',
                'package_id',
                'additional_details',
                'masking_allowed',
                'status'
            ]);

            // Map form's 'first_name' to database 'name' column
            $data['name'] = $request->first_name;

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}