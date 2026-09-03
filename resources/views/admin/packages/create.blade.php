@extends('admin.layouts.app')

@section('title', 'Create Package | Constant Emails')

@push('styles')
    <!--  BEGIN CUSTOM STYLE FILE  -->
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
            /* Consistent height for all inputs */
        }

        /* Style for readonly inputs to look inactive */
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

        .form-control::-webkit-input-placeholder {
            color: #d3d3d3;
            font-size: 15px;
        }

        .form-control::-ms-input-placeholder {
            color: #d3d3d3;
            font-size: 15px;
        }

        .form-control::-moz-placeholder {
            color: #d3d3d3;
            font-size: 15px;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: #3862f5;
            box-shadow: none;
        }

        label {
            color: #3b3f5c;
            font-weight: 600;
            margin-bottom: 8px !important;
        }

        /* Highlight input when there is an error */
        .is-invalid {
            border-color: #e7515a !important;
        }
    </style>
    <!--  END CUSTOM STYLE FILE  -->
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Add New Package</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="{{ route('packages.index') }}">Packages</a></li>
                    <li class="active"><a href="#">Create</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flash Messages & Global Errors -->
    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong> {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row layout-spacing">
        <div class="col-lg-12 col-12">

            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Package Details</h4>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <form action="{{ route('packages.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!-- Package Name -->
                            <div class="col-md-6 mb-4">
                                <label for="packageName">Package Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-notes"></i></span>
                                    </div>
                                    <input type="text" id="packageName" name="package_name"
                                        class="form-control-rounded-right form-control @error('package_name') is-invalid @enderror"
                                        placeholder="e.g. Professional Plan" value="{{ old('package_name') }}" required>
                                </div>
                                @error('package_name')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Stripe ID (Readonly) -->
                            <div class="col-md-6 mb-4">
                                <label for="stripeId">Stripe ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-credit-card"></i></span>
                                    </div>
                                    <input type="text" id="stripeId" name="stripe_id"
                                        class="form-control-rounded-right form-control"
                                        placeholder="generated by Stripe" value="{{ old('stripe_id') }}">
                                </div>
                            </div>

                            <!-- Package Price -->
                            <div class="col-md-6 mb-4">
                                <label for="packagePrice">Package Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" id="packagePrice" name="package_price"
                                        class="form-control @error('package_price') is-invalid @enderror" placeholder="0.00"
                                        aria-label="Amount" value="{{ old('package_price') }}">
                                    <div class="input-group-append">
                                        <span class="form-control-rounded-right input-group-text">USD</span>
                                    </div>
                                </div>
                                @error('package_price')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Package Emails Allowed -->
                            <div class="col-md-6 mb-4">
                                <label for="packageEmails">No. of Emails Allowed <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-mail-fill"></i></span>
                                    </div>
                                    <input type="number" id="packageEmails" name="package_emails"
                                        class="form-control-rounded-right form-control @error('package_emails') is-invalid @enderror"
                                        placeholder="e.g. 10000" value="{{ old('package_emails', 0) }}" required>
                                </div>
                                @error('package_emails')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6 mb-4">
                                <label for="duration">Duration <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-calendar-1"></i></span>
                                    </div>
                                    <input type="number" id="duration" name="duration"
                                        class="form-control @error('duration') is-invalid @enderror" placeholder="e.g. 12"
                                        value="{{ old('duration', 0) }}" required>
                                    <div class="input-group-append">
                                        <span class="form-control-rounded-right input-group-text">Months</span>
                                    </div>
                                </div>
                                @error('duration')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Access Level -->
                            <div class="col-md-6 mb-4">
                                <label for="accessLevel">Access Level <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-user-11"></i></span>
                                    </div>
                                    <select
                                        class="form-control form-control-rounded-right custom-select @error('access_level') is-invalid @enderror"
                                        id="accessLevel" name="access_level" required>
                                        <option value="user" {{ old('access_level') == 'user' ? 'selected' : '' }}>User
                                        </option>
                                        <option value="admin" {{ old('access_level') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                </div>
                                @error('access_level')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-4">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-power-button"></i></span>
                                    </div>
                                    <select
                                        class="form-control form-control-rounded-right custom-select @error('status') is-invalid @enderror"
                                        id="status" name="status" required>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Deactive" {{ old('status') == 'Deactive' ? 'selected' : '' }}>Deactive
                                        </option>
                                        <option value="Deleted" {{ old('status') == 'Deleted' ? 'selected' : '' }}>Deleted
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('packages.index') }}" class="btn btn-dark btn-rounded mr-2">Cancel</a>
                                <button type="submit" class="btn btn-gradient-warning btn-rounded">Save Package</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection