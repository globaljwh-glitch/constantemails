@extends('admin.layouts.app')

@section('title', 'Manage Email Templates | Constant Emails')

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

        .template-name {
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

        .table-controls>li>a:hover i.flaticon-edit-fill-2 {
            color: #00b1f4;
        }

        .table-controls>li>button:hover i.flaticon-delete-fill {
            color: #e7515a;
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
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Manage Email Templates</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Templates</a></li>
                    <li class="active"><a href="#">Email Templates</a> </li>
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
                            <h4>Email Templates</h4>
                        </div>
                        <div
                            class="col-xl-8 col-md-8 col-sm-12 col-12 d-flex justify-content-end align-items-center mt-sm-0 mt-3 pr-4">
                            <form action="{{ route('email-templates.index') }}" method="GET" class="mr-3"
                                style="max-width: 300px; width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search templates..."
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit"
                                            style="border-radius: 0 4px 4px 0;">Search</button>
                                        @if(request('search')) <a href="{{ route('email-templates.index') }}"
                                        class="btn btn-danger">Clear</a> @endif
                                    </div>
                                </div>
                            </form>
                            <a href="{{ route('email-templates.create') }}" class="btn btn-gradient-warning btn-rounded"
                                style="height: 42px; line-height: 28px;">
                                <i class="flaticon-plus"></i> Add New Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-4 text-center">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">#</th>
                                    <th>Image</th>
                                    <th class="text-left">Template Name</th>
                                    <th>Date Created</th>
                                    <th>Status</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $key => $template)
                                    <tr>
                                        <td>{{ ($templates->currentPage() - 1) * $templates->perPage() + $key + 1 }}</td>
                                        <td>
                                            @if($template->mail_template_image)
                                                <img src="{{ asset('storage/' . $template->mail_template_image) }}" alt="thumb"
                                                    style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td class="text-left"><span
                                                class="template-name">{{ $template->mail_template_name }}</span></td>
                                        <td>{{ $template->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $template->status == 'Active' ? 'success' : 'warning' }} shadow-none badge-pill">{{ $template->status }}</span>
                                        </td>
                                        <td>
                                            <ul class="table-controls mb-0">
                                                <li><a href="{{ route('email-templates.edit', $template->id) }}"
                                                        data-toggle="tooltip" title="Edit"><i
                                                            class="flaticon-edit-fill-2 fs-20"></i></a></li>
                                                <li>
                                                    <form action="{{ route('email-templates.destroy', $template->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf @method('DELETE')
                                                        <button type="button" class="btn-delete-item"
                                                            style="border: none; background: none; padding: 0;"
                                                            data-toggle="tooltip" title="Delete"><i
                                                                class="flaticon-delete-fill fs-20"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-4">No email templates found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-section">
                        @if($templates instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {!! $templates->appends(request()->query())->links('pagination::bootstrap-4') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $(document).on('click', '.btn-delete-item', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?', text: "This cannot be undone!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#e7515a', cancelButtonColor: '#3b3f5c', confirmButtonText: 'Yes, delete it!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });
    </script>
@endpush