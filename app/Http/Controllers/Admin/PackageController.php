<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationPackage;
use Illuminate\Support\Facades\Log;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index()
    {
        // Fetch all packages, ordered by the newest first
        $packages = RegistrationPackage::orderBy('created_at', 'desc')->get();

        return view('admin.packages.all_packages', compact('packages'));
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(Request $request)
    {
        // Professional Validation Rules
        $validatedData = $request->validate([
            'package_name' => 'required|string|max:255|unique:registration_packages,package_name',
            'stripe_id' => 'nullable|string|max:255', // Added Stripe ID validation
            'package_price' => 'nullable|numeric|min:0',
            'package_emails' => 'required|integer|min:0',
            'duration' => 'required|integer|min:0',
            'access_level' => 'required|in:admin,user',
            'status' => 'required|in:Active,Deactive,Deleted',
        ], [
            // Custom Error Messages
            'package_name.unique' => 'A package with this name already exists.',
            'package_price.min' => 'The price cannot be negative.',
        ]);

        try {


            // Create the package
            RegistrationPackage::create($validatedData);

            return redirect()->route('packages.index')->with('success', 'Package created successfully!');

        } catch (\Exception $e) {
            // Log the exact error for the developer
            Log::error('Error creating package: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong while creating the package.')->withInput();
        }
    }

    /**
     * Fetch a specific package's data for the Edit Modal (Returns JSON).
     */
    public function edit($id)
    {
        $package = RegistrationPackage::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    /**
     * Update the specified package in storage.
     */
    public function update(Request $request, $id)
    {
        $package = RegistrationPackage::findOrFail($id);


        $validatedData = $request->validate([
            'package_name' => 'required|string|max:255|unique:registration_packages,package_name,' . $package->id,
            'stripe_id' => 'nullable|string|max:255', // Added Stripe ID validation
            'package_price' => 'nullable|numeric|min:0',
            'package_emails' => 'required|integer|min:0',
            'duration' => 'required|integer|min:0',
            'access_level' => 'required|in:admin,user',
            'status' => 'required|in:Active,Deactive,Deleted',
        ]);

        try {

            $package->update($validatedData);


            return redirect()->route('packages.index')->with('success', 'Package updated successfully!');

        } catch (\Exception $e) {
            Log::error('Error updating package: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong while updating the package.')->withInput();
        }
    }

    /**
     * Remove the specified package from storage.
     */
    public function destroy($id)
    {
        try {
            $package = RegistrationPackage::findOrFail($id);
            $package->delete();

            return redirect()->back()->with('success', 'Package deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting package: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong while deleting the package.');
        }
    }
}