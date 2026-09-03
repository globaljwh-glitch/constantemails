@extends('admin.layouts.app')

@section('title', 'Manage Users | Constant Emails')

@push('styles')
    <style>
        .table td,
        .table th {
            border-top: 1px solid #080908;
            vertical-align: middle;
        }

        .table th {
            color: #000000 !important;
            font-weight: 700 !important;
        }

        .user-name {
            color: #000000 !important;
            font-weight: 700 !important;
        }

        .table-controls {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .table-controls>li>a i,
        .table-controls>li>button i {
            color: #0e0d0d;
            transition: color 0.3s;
            font-size: 18px;
        }

        .table-controls>li>a:hover i {
            color: #00b1f4;
        }

        .badge {
            font-weight: 600;
            padding: 6px 10px;
        }

        .pagination-section nav {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .form-control {
            border: 1px solid #ccc;
            color: #888ea8;
            font-size: 15px;
            height: 42px;
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
                    <li class="active"><a href="#">All Users</a> </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success mb-4"><button type="button" class="close"
                        data-dismiss="alert"><span>&times;</span></button><strong>Success!</strong> {{ session('success') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row layout-spacing">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row align-items-center">
                        <div class="col-xl-4 col-md-4 col-sm-12 col-12">
                            <h4>Users List</h4>
                        </div>
                        <div
                            class="col-xl-8 col-md-8 col-sm-12 col-12 d-flex justify-content-end align-items-center mt-sm-0 mt-3 pr-4">
                            <form action="{{ route('users.index') }}" method="GET" class="mr-3"
                                style="max-width: 300px; width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search users..."
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit"
                                            style="border-radius: 0 4px 4px 0;">Search</button>
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('users.create') }}" class="btn btn-gradient-warning btn-rounded"
                                style="height: 42px; line-height: 28px;">
                                <i class="flaticon-user-plus"></i> Add New User
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-4 text-center">
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th>City</th>
                                    <th>Email</th>
                                    <th>Package</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>View Campaign</th>
                                    <th>View Statistics</th>
                                    <th>Print Agreement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="text-left"><span class="user-name">{{ $user->name }}</span></td>
                                        <td>{{ $user->city ?? '-' }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span
                                                class="badge badge-info shadow-none">{{ $user->package->package_name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $user->status == 'Active' ? 'success' : 'warning' }} shadow-none">{{ $user->status }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}" data-toggle="tooltip" title="Edit"><i
                                                    class="flaticon-edit-fill-2 text-primary fs-20"></i></a>
                                        </td>
                                        <td><a href="#" class="btn-action-text">View</a></td>
                                        <td><a href="#" class="btn-action-text">View</a></td>
                                        <td><a href="#" class="btn-action-text">View</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">No users found.</td>
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
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush