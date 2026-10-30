@extends('admin.layouts.app')

@section('title', 'Manage Users | Constant Emails')

@push('styles')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css">

    <style>
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        /* Clean table headers - bold, dark, and clear */
        .table thead th {
            background-color: #f4f6f9 !important;
            color: #111111 !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e0e6ed !important;
            border-top: none !important;
            padding: 16px 12px !important;
            vertical-align: middle;
        }

        .table td {
            border-top: 1px solid #ebedf2;
            vertical-align: middle;
            padding: 14px 12px;
            color: #3b3f5c;
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background-color: #fcfdfe;
        }

        .user-name {
            color: #0e1726 !important;
            font-weight: 700 !important;
            font-size: 14px;
        }

        .table-controls {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .table-controls>li>a i,
        .table-controls>li>button i {
            color: #888ea8;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .table-controls>li>a:hover i.flaticon-edit-fill-2 {
            color: #0b0b0b;
        }

        .table-controls>li>button:hover i.flaticon-delete-fill {
            color: #e7515a;
        }

        .badge {
            font-weight: 600;
            padding: 6px 12px;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .pagination-section nav {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .form-control {
            border: 1px solid #bfc9d4;
            color: #3b3f5c;
            font-size: 14px;
            height: 42px;
            border-radius: 8px 0 0 8px;
        }

        .form-control:focus {
            border-color: #2196f3;
            box-shadow: none;
        }

        .btn-action-text {
            font-weight: 600;
            font-size: 13px;
            color: #6156ce;
            text-decoration: underline;
        }

        .btn-action-text:hover {
            color: #3862f5;
        }

        .widget.box {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Manage Users</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i> Home</a></li>
                    <li><a href="#">Manage Users</a></li>
                    <li class="active"><a href="#">All Users</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header pb-3">
                    <div class="row align-items-center w-100 m-0">
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12 p-0">
                            <h4 class="font-weight-bold text-dark">Users List</h4>
                        </div>
                        <div
                            class="col-xl-8 col-md-8 col-sm-12 col-12 d-flex justify-content-end align-items-center mt-sm-0 mt-3 p-0">
                            <form action="{{ route('users.index') }}" method="GET" class="mr-3"
                                style="max-width: 320px; width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search users..."
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit"
                                            style="border-radius: 0 8px 8px 0; padding: 0 16px;">Search</button>
                                        @if(request('search'))
                                            <a href="{{ route('users.index') }}" class="btn btn-danger ml-2"
                                                style="border-radius: 8px;">Clear</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('users.create') }}" class="btn btn-gradient-warning btn-rounded"
                                style="height: 42px; display: inline-flex; align-items: center; gap: 6px; border-radius: 8px;">
                                <i class="flaticon-user-plus"></i> Add New User
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover mb-4 text-center">
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th>City</th>
                                    <th>Email</th>
                                    <th>Package</th>
                                    <th>Date Created</th>
                                    <th>Status</th>

                                    <th>View Statistics</th>
                                    <th>Print Agreement</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="text-left">
                                            <span class="user-name">{{ $user->name }}</span>
                                        </td>
                                        <td>{{ $user->city ?? '-' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-info shadow-none badge-pill">
                                                {{ optional($user->package)->package_name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted font-weight-medium" style="font-size: 13px;">
                                                {{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-pill badge-{{ $user->status == 'Active' ? 'success' : 'warning' }}">
                                                {{ $user->status }}
                                            </span>
                                        </td>

                                        <td><a href="#" class="btn-action-text">View</a></td>
                                        <td><a href="#" class="btn-action-text">View</a></td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" data-toggle="tooltip"
                                                title="Edit User">
                                                <i class="flaticon-edit-fill-2 text-primary fs-20"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-delete-item"
                                                    style="border: none; background: none; padding: 0; cursor: pointer;"
                                                    data-toggle="tooltip" title="Delete User">
                                                    <i class="flaticon-delete-fill text-danger fs-20"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5 text-muted font-italic">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-section">
                        @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {!! $users->appends(request()->query())->links('pagination::bootstrap-4') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize Tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // SweetAlert Delete Confirmation
            $(document).on('click', '.btn-delete-item', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this user!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e7515a',
                    cancelButtonColor: '#3b3f5c',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Global Flash Messages with SweetAlert
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
                    text: "{{ session('error') }}"
                });
            @endif
                    });
    </script>
@endpush