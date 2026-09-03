<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationPackage; // <-- Updated Model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('package')->where('is_admin', 0); // Exclude admins if desired

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
        // <-- Updated to use RegistrationPackage
        $packages = RegistrationPackage::where('status', 'Active')->get();
        return view('admin.users.form', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'status' => 'required|in:Active,Deactive',
            // <-- Updated table name in validation
            'package_id' => 'required|exists:registration_packages,id'
        ]);

        try {
            $data = $request->all();
            $data['name'] = $request->first_name . ' ' . $request->last_name;
            $data['password'] = Hash::make($request->password);
            $data['account_type'] = 'user';

            User::create($data);
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating user.')->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // <-- Updated to use RegistrationPackage
        $packages = RegistrationPackage::where('status', 'Active')->get();

        // Split name back to first and last for the form
        $nameParts = explode(' ', $user->name, 2);
        $user->first_name = $nameParts[0] ?? '';
        $user->last_name = $nameParts[1] ?? '';

        return view('admin.users.form', compact('user', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'status' => 'required|in:Active,Deactive',
            // <-- Updated table name in validation
            'package_id' => 'required|exists:registration_packages,id'
        ]);

        try {
            $data = $request->except(['password']);
            $data['name'] = $request->first_name . ' ' . $request->last_name;

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating user.')->withInput();
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