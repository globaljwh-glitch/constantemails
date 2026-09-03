@extends('admin.layouts.app')

@section('title', 'Global Settings | Constant Emails')

@push('styles')
    <style>
        .form-control,
        .custom-select {
            border: 1px solid #ccc;
            color: #888ea8;
            font-size: 15px;
            height: 48px;
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
            box-shadow: none;
        }

        label {
            color: #3b3f5c;
            font-weight: 600;
            margin-bottom: 8px !important;
        }

        /* Section Titles */
        h5.section-title {
            font-weight: 700;
            color: #000;
            margin-bottom: 25px;
            margin-top: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f3f4f7;
            display: flex;
            align-items: center;
        }

        h5.section-title i {
            margin-right: 10px;
            color: #6156ce;
            font-size: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Global Configuration</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Settings</a></li>
                    <li class="active"><a href="#">Global Configuration</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success mb-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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
                            <h4>Manage Site Settings</h4>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area p-4">
                    <form action="{{ route('settings.store') }}" method="POST">
                        @csrf

                        <!-- ================= 1. GENERAL SETTINGS ================= -->
                        <h5 class="section-title"><i class="flaticon-settings-7"></i> General Details</h5>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label>Site Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-computer-line"></i></span></div>
                                    <input type="text" name="site_name" class="form-control form-control-rounded-right"
                                        placeholder="e.g. Constant Emails" value="{{ $settings['site_name'] ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label>Admin Contact Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-mail-fill"></i></span></div>
                                    <input type="email" name="admin_email" class="form-control form-control-rounded-right"
                                        placeholder="admin@domain.com" value="{{ $settings['admin_email'] ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label>Support Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-telephone"></i></span></div>
                                    <input type="text" name="support_phone" class="form-control form-control-rounded-right"
                                        placeholder="+1 234 567 8900" value="{{ $settings['support_phone'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- ================= 2. SMTP SETTINGS ================= -->
                        <h5 class="section-title mt-4"><i class="flaticon-email-fill-1"></i> Email / SMTP Configuration</h5>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label>Mail Host</label>
                                <input type="text" name="mail_host" class="form-control rounded"
                                    placeholder="smtp.mailtrap.io" value="{{ $settings['mail_host'] ?? '' }}">
                            </div>

                            <div class="col-md-2 mb-4">
                                <label>Mail Port</label>
                                <input type="text" name="mail_port" class="form-control rounded" placeholder="2525"
                                    value="{{ $settings['mail_port'] ?? '' }}">
                            </div>

                            <div class="col-md-2 mb-4">
                                <label>Encryption</label>
                                <select name="mail_encryption" class="form-control rounded custom-select">
                                    <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>
                                        TLS</option>
                                    <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>
                                        SSL</option>
                                    <option value="none" {{ ($settings['mail_encryption'] ?? '') == 'none' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Mail Username</label>
                                <input type="text" name="mail_username" class="form-control rounded" placeholder="Username"
                                    value="{{ $settings['mail_username'] ?? '' }}">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Mail Password</label>
                                <input type="password" name="mail_password" class="form-control rounded"
                                    placeholder="••••••••" value="{{ $settings['mail_password'] ?? '' }}">
                            </div>
                        </div>

                        <!-- ================= 3. PAYMENT API KEYS ================= -->
                        <h5 class="section-title mt-4"><i class="flaticon-credit-card"></i> Payment Gateways</h5>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label>Stripe Public Key</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-link-1"></i></span></div>
                                    <input type="text" name="stripe_public_key"
                                        class="form-control form-control-rounded-right" placeholder="pk_live_..."
                                        value="{{ $settings['stripe_public_key'] ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label>Stripe Secret Key</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-lock-2"></i></span></div>
                                    <input type="text" name="stripe_secret_key"
                                        class="form-control form-control-rounded-right" placeholder="sk_live_..."
                                        value="{{ $settings['stripe_secret_key'] ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label>PayPal Client ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-copy-line"></i></span></div>
                                    <input type="text" name="paypal_client_id"
                                        class="form-control form-control-rounded-right" placeholder="PayPal Client Hash"
                                        value="{{ $settings['paypal_client_id'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4 mb-4">

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12 text-right">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-rounded mr-2">Cancel</a>
                                <button type="submit" class="btn btn-gradient-warning btn-rounded">
                                    Save Configuration
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection