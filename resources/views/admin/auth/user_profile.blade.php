@extends('admin.layouts.app')

@section('title', 'My Profile | Constant Emails')

@push('styles')
    <style>
        .form-control {
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

        .form-control:focus {
            border-color: #3862f5;
            box-shadow: none;
        }

        label {
            color: #3b3f5c;
            font-weight: 600;
            margin-bottom: 8px !important;
        }

        .is-invalid {
            border-color: #e7515a !important;
        }

        .profile-image-container {
            text-align: center;
            padding: 30px 20px;
        }

        .profile-img-preview {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #f3f4f7;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .user-role-badge {
            background: #6156ce;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .nav-pills .nav-link.active {
            background-color: #f6993f;
            color: #fff;
            border-radius: 30px;
            padding: 10px 25px;
            box-shadow: 0 4px 10px rgba(246, 153, 63, 0.3);
        }

        .nav-pills .nav-link {
            color: #3b3f5c;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 30px;
            transition: 0.3s;
        }

        .nav-pills .nav-link:hover {
            color: #f6993f;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>My Profile</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Settings</a></li>
                    <li class="active"><a href="#">My Profile</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success mb-4"><button type="button" class="close"
                        data-dismiss="alert"><span>&times;</span></button><strong>Success!</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-4"><button type="button" class="close"
                        data-dismiss="alert"><span>&times;</span></button><strong>Error!</strong> {{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">@foreach ($errors->all() as $error)
                    <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row layout-spacing">
        <!-- LEFT: Profile Card -->
        <div class="col-xl-4 col-lg-5 col-md-5 col-sm-12 mb-4">
            <div class="statbox widget box box-shadow h-100">
                <div class="widget-content widget-content-area profile-image-container h-100">
                    <!-- <img src="{{ asset('assets/img/200x200.jpg') }}" alt="avatar" class="profile-img-preview"> -->
                    <h4 class="mt-2 text-dark font-weight-bold">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <span class="user-role-badge">{{ $user->is_admin ? 'Administrator' : 'User' }}</span>

                    <hr class="mt-4 mb-4">

                    <div class="text-left px-3">
                        <p><strong><i class="flaticon-user-11 mr-2 text-primary"></i> Username:</strong>
                            {{ $user->username }}</p>
                        <p><strong><i class="flaticon-calendar-1 mr-2 text-primary"></i> Joined:</strong>
                            {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Tabs & Forms -->
        <div class="col-xl-8 col-lg-7 col-md-7 col-sm-12">
            <div class="statbox widget box box-shadow h-100">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 p-4 pb-0">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-details-tab" data-toggle="pill"
                                        href="#pills-details" role="tab" aria-selected="true"><i
                                            class="flaticon-user-line mr-1"></i> Edit Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-password-tab" data-toggle="pill" href="#pills-password"
                                        role="tab" aria-selected="false"><i class="flaticon-lock-2 mr-1"></i> Change
                                        Password</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area p-4 pt-2">
                    <div class="tab-content" id="pills-tabContent">

                        <!-- TAB 1: Edit Details -->
                        <div class="tab-pane fade show active" id="pills-details" role="tabpanel">
                            <form action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label>First Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-user-11"></i></span></div>
                                            <input type="text" name="first_name"
                                                class="form-control form-control-rounded-right"
                                                value="{{ old('first_name', $user->first_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label>Last Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-user-11"></i></span></div>
                                            <input type="text" name="last_name"
                                                class="form-control form-control-rounded-right"
                                                value="{{ old('last_name', $user->last_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-user-line"></i></span></div>
                                            <input type="text" name="username"
                                                class="form-control form-control-rounded-right"
                                                value="{{ old('username', $user->username) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label>Email Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-mail-fill"></i></span></div>
                                            <input type="email" name="email" class="form-control form-control-rounded-right"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-gradient-warning btn-rounded">Update
                                        Details</button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB 2: Change Password -->
                        <div class="tab-pane fade" id="pills-password" role="tabpanel">
                            <form action="{{ route('admin.profile.password') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label>Current Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-lock-2"></i></span></div>
                                            <input type="password" name="current_password"
                                                class="form-control form-control-rounded-right"
                                                placeholder="Enter current password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label>New Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-key-2"></i></span></div>
                                            <input type="password" name="new_password"
                                                class="form-control form-control-rounded-right" placeholder="New password"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label>Confirm New Password</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span
                                                    class="form-control-rounded-left input-group-text"><i
                                                        class="flaticon-key-2"></i></span></div>
                                            <input type="password" name="new_password_confirmation"
                                                class="form-control form-control-rounded-right"
                                                placeholder="Confirm new password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-gradient-primary btn-rounded"
                                        style="background: #6156ce; border-color: #6156ce;">Update Password</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection