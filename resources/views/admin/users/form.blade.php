@extends('admin.layouts.app')

@section('title', isset($user) ? 'Edit User | Constant Emails' : 'Create User | Constant Emails')

@push('styles')
    <!-- BEGIN CUSTOM STYLE FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css">
    <style type="text/css">
        .custom-control {
            margin-top: -5px;
        }

        .form-control,
        .custom-select {
            border: 1px solid #ccc;
            color: #888ea8;
            font-size: 15px;
            height: 48px;
            transition: all 0.3s ease;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        .input-group-text {
            background-color: #f3f4f7;
            border-color: #ccc;
            color: #6156ce;
            font-weight: 600;
            padding: 0 15px;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: #3862f5;
            box-shadow: 0 0 0 0.2rem rgba(56, 98, 245, 0.15);
        }

        label {
            color: #3b3f5c;
            font-weight: 600;
            margin-bottom: 8px !important;
        }

        .is-invalid {
            border-color: #e7515a !important;
            background-image: none !important;
        }

        /* Beautiful Smooth Validation Error Animation */
        .invalid-feedback-custom {
            display: block;
            width: 100%;
            margin-top: 6px;
            font-size: 125%;
            font-weight: 500;
            color: #e7515a;
            animation: fadeInDown 0.35s ease-in-out forwards;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h5.section-title {
            font-weight: 700;
            color: #000;
            margin-bottom: 25px;
            margin-top: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f3f4f7;
        }
    </style>
    <!-- END CUSTOM STYLE FILE -->
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>{{ isset($user) ? 'Edit User' : 'Add New User' }}</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                    <li class="active"><a href="#">{{ isset($user) ? 'Edit' : 'Create' }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row layout-spacing">
        <div class="col-lg-12 col-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>User Details</h4>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area p-4">
                    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($user)) @method('PUT') @endif

                        <!-- ================= ACCOUNT INFO ================= -->
                        <h5 class="section-title">Account Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-user-11"></i></span></div>
                                    <input type="text" id="username" name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Username" value="{{ old('username', $user->username ?? '') }}" required>
                                </div>
                                @error('username')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-mail-fill"></i></span></div>
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email Address" value="{{ old('email', $user->email ?? '') }}" required>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="password">Password @if(!isset($user))<span class="text-danger">*</span>@else<small class="text-muted">(Leave blank to keep)</small>@endif</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-lock-2"></i></span></div>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="******" {{ isset($user) ? '' : 'required' }}>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- ================= CONTACT INFO ================= -->
                        <h5 class="section-title">Contact Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-user-11"></i></span></div>
                                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                        placeholder="First Name" value="{{ old('first_name', $user->first_name ?? '') }}" required>
                                </div>
                                @error('first_name')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-user-11"></i></span></div>
                                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="Last Name" value="{{ old('last_name', $user->last_name ?? '') }}" required>
                                </div>
                                @error('last_name')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label>Company Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-home-fill"></i></span></div>
                                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                                        placeholder="Company Name" value="{{ old('company_name', $user->company_name ?? '') }}">
                                </div>
                                @error('company_name')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label>Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-location-line"></i></span></div>
                                    <input type="text" name="company_address" class="form-control @error('company_address') is-invalid @enderror" placeholder="Full Address"
                                        value="{{ old('company_address', $user->company_address ?? '') }}">
                                </div>
                                @error('company_address')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label>City</label>
                                <input type="text" name="city" class="form-control rounded @error('city') is-invalid @enderror" placeholder="City" value="{{ old('city', $user->city ?? '') }}">
                                @error('city')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>State</label>
                                <input type="text" name="state" class="form-control rounded @error('state') is-invalid @enderror" placeholder="State" value="{{ old('state', $user->state ?? '') }}">
                                @error('state')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>Country</label>
                                <input type="text" name="country" class="form-control rounded @error('country') is-invalid @enderror" placeholder="Country" value="{{ old('country', $user->country ?? '') }}">
                                @error('country')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>Zip</label>
                                <input type="text" name="zip" class="form-control rounded @error('zip') is-invalid @enderror" placeholder="Zip Code" value="{{ old('zip', $user->zip ?? '') }}">
                                @error('zip')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Phone</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-telephone"></i></span></div>
                                    <input type="text" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" placeholder="Phone Number"
                                        value="{{ old('company_phone', $user->company_phone ?? '') }}">
                                </div>
                                @error('company_phone')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Fax</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-telephone"></i></span></div>
                                    <input type="text" name="company_fax" class="form-control @error('company_fax') is-invalid @enderror" placeholder="Fax Number" value="{{ old('company_fax', $user->company_fax ?? '') }}">
                                </div>
                                @error('company_fax')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- ================= BILLING INFO ================= -->
                        <h5 class="section-title">Billing Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Billing First Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-user-11"></i></span></div>
                                    <input type="text" name="billing_first_name" class="form-control @error('billing_first_name') is-invalid @enderror" placeholder="First Name"
                                        value="{{ old('billing_first_name', $user->billing_first_name ?? '') }}">
                                </div>
                                @error('billing_first_name')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label>Billing Last Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-user-11"></i></span></div>
                                    <input type="text" name="billing_last_name" class="form-control @error('billing_last_name') is-invalid @enderror" placeholder="Last Name"
                                        value="{{ old('billing_last_name', $user->billing_last_name ?? '') }}">
                                </div>
                                @error('billing_last_name')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label>Billing Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-location-line"></i></span></div>
                                    <input type="text" name="billing_address" class="form-control @error('billing_address') is-invalid @enderror" placeholder="Billing Address"
                                        value="{{ old('billing_address', $user->billing_address ?? '') }}">
                                </div>
                                @error('billing_address')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label>City</label>
                                <input type="text" name="billing_city" class="form-control rounded @error('billing_city') is-invalid @enderror" placeholder="City" value="{{ old('billing_city', $user->billing_city ?? '') }}">
                                @error('billing_city')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>State</label>
                                <input type="text" name="billing_state" class="form-control rounded @error('billing_state') is-invalid @enderror" placeholder="State" value="{{ old('billing_state', $user->billing_state ?? '') }}">
                                @error('billing_state')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>Country</label>
                                <input type="text" name="billing_country" class="form-control rounded @error('billing_country') is-invalid @enderror" placeholder="Country" value="{{ old('billing_country', $user->billing_country ?? '') }}">
                                @error('billing_country')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>Zip</label>
                                <input type="text" name="billing_zip" class="form-control rounded @error('billing_zip') is-invalid @enderror" placeholder="Zip" value="{{ old('billing_zip', $user->billing_zip ?? '') }}">
                                @error('billing_zip')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- ================= PACKAGE DETAILS ================= -->
                        <h5 class="section-title">Package Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Package Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-notes"></i></span></div>
                                    <select name="package_id" class="custom-select @error('package_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('package_id', $user->package_id ?? '') == '' ? 'selected' : '' }}>----Select Package----</option>
                                        @foreach($packages as $pkg)
                                            <option value="{{ $pkg->id }}" {{ old('package_id', $user->package_id ?? '') == $pkg->id ? 'selected' : '' }}>{{ $pkg->package_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('package_id')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Additional Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-mail-fill"></i></span></div>
                                    <input type="text" name="additional_details" class="form-control @error('additional_details') is-invalid @enderror" placeholder="Additional Details"
                                        value="{{ old('additional_details', $user->additional_details ?? '') }}">
                                </div>
                                @error('additional_details')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Masking Allowed</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-view"></i></span></div>
                                    <select name="masking_allowed" class="custom-select @error('masking_allowed') is-invalid @enderror">
                                        <option value="1" {{ old('masking_allowed', $user->masking_allowed ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('masking_allowed', $user->masking_allowed ?? 0) == 0 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                @error('masking_allowed')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-power-button"></i></span></div>
                                    <select name="status" class="custom-select @error('status') is-invalid @enderror" required>
                                        <option value="Active" {{ old('status', $user->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Deactive" {{ old('status', $user->status ?? '') == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="invalid-feedback-custom">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('users.index') }}" class="btn btn-dark btn-rounded mr-2">Cancel</a>
                                <button type="submit" class="btn btn-gradient-warning btn-rounded">
                                    {{ isset($user) ? 'Update User' : 'Save User' }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        @endif
    </script>
@endpush