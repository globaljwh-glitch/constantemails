@extends('admin.layouts.app')

@section('title', 'Contact Categories | Constant Emails')

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

        .category-name {
            color: #000000 !important;
            font-weight: 700 !important;
        }

        .table-controls {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .table-controls>li {
            display: inline-block;
            margin: 0 2px;
        }

        .table-controls>li>a i,
        .table-controls>li>button i {
            color: #0e0d0d;
            transition: color 0.3s;
        }

        /* Icon Hover Colors */
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

        .is-invalid {
            border-color: #e7515a !important;
        }

        .pagination-section nav {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .page-item.active .page-link {
            background-color: #f6993f;
            border-color: #f6993f;
            color: #fff;
        }

        .page-link {
            color: #3b3f5c;
            border-radius: 4px;
            margin: 0 3px;
        }

        .page-link:hover {
            color: #f6993f;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Contact Categories</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Contacts</a></li>
                    <li class="active"><a href="#">Categories</a></li>
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
        </div>
    </div>

    <!-- TOP SECTION: CREATE / EDIT FORM -->
    <div class="row layout-spacing" id="formSection">
        <div class="col-lg-12 col-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4 id="formTitle">Add New Category</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form id="categoryForm" action="{{ route('contact-categories.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="methodField" value="POST">

                        <div class="row align-items-end">
                            <div class="col-md-7 mb-4">
                                <label for="categoryName">Category Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span
                                            class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-user-group"></i></span></div>
                                    <input type="text" id="categoryName" name="name"
                                        class="form-control-rounded-right form-control @error('name') is-invalid @enderror"
                                        placeholder="e.g. VIP Clients" value="{{ old('name') }}" required>
                                </div>
                                @error('name') <span class="text-danger small mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-3 mb-4">
                                <label for="status">Status</label>
                                <select class="form-control custom-select rounded @error('status') is-invalid @enderror"
                                    id="status" name="status">
                                    <option value="Active" selected>Active</option>
                                    <option value="Deactive">Deactive</option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-4 d-flex">
                                <button type="button" id="cancelEditBtn" class="btn btn-dark rounded d-none mr-2"
                                    style="height: 48px; font-weight: 600; width: 40%;">Cancel</button>
                                <button type="submit" id="submitBtn" class="btn btn-gradient-warning rounded w-100"
                                    style="height: 48px; font-weight: 600;">Save Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM SECTION: LIST TABLE -->
    <div class="row layout-spacing">
        <div class="col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12">
                            <h4>Manage Categories</h4>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 col-12 d-flex justify-content-end mt-sm-0 mt-3">
                            <form action="{{ route('contact-categories.index') }}" method="GET"
                                style="max-width: 350px; width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search categories..."
                                        value="{{ request('search') }}" style="height: 42px;">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit"
                                            style="height: 42px; border-radius: 0 4px 4px 0;">Search</button>
                                        @if(request('search'))
                                            <a href="{{ route('contact-categories.index') }}" class="btn btn-danger"
                                                style="height: 42px; line-height: 28px;">Clear</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-4">
                            <thead>
                                <tr>
                                    <th class="align-center" style="width: 80px;">#</th>
                                    <th>Category Name</th>
                                    <th class="text-center">Date Created</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $key => $category)
                                    <tr>
                                        <td class="align-center">
                                            {{ ($categories->currentPage() - 1) * $categories->perPage() + $key + 1 }}</td>
                                        <td><span class="category-name">{{ $category->name }}</span></td>
                                        <td class="text-center">{{ $category->created_at->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            @if($category->status == 'Active')
                                                <span class="badge badge-success shadow-none badge-pill">Active</span>
                                            @else
                                                <span class="badge badge-warning shadow-none badge-pill">Deactive</span>
                                            @endif
                                        </td>
                                        <td class="align-center">
                                            <ul class="table-controls mb-0">
                                                <li>
                                                    <a href="javascript:void(0);" class="btn-edit-category"
                                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                        data-status="{{ $category->status }}" data-toggle="tooltip"
                                                        data-placement="top" title="Edit">
                                                        <i class="flaticon-edit-fill-2 fs-20"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('contact-categories.destroy', $category->id) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn-delete-category"
                                                            style="border: none; background: none; padding: 0; outline: none;"
                                                            data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="flaticon-delete-fill fs-20"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No contact categories found. Create
                                            one above!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-section">
                        @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {!! $categories->appends(request()->query())->links('pagination::bootstrap-4') !!}
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

            // Inline Editing
            $(document).on('click', '.btn-edit-category', function () {
                let id = $(this).data('id');
                $('#categoryName').val($(this).data('name'));
                $('#status').val($(this).data('status'));

                $('#formTitle').text('Edit Category');
                $('#submitBtn').text('Update Category');
                $('#cancelEditBtn').removeClass('d-none');

                let updateBaseUrl = "{{ url('admin/contact-categories') }}";
                $('#categoryForm').attr('action', updateBaseUrl + '/' + id + '/update');
                $('#methodField').val('PUT');

                $('html, body').animate({ scrollTop: $("#formSection").offset().top - 100 }, 500);
            });

            $('#cancelEditBtn').on('click', function () {
                $('#categoryForm')[0].reset();
                $('#formTitle').text('Add New Category');
                $('#submitBtn').text('Save Category');
                $(this).addClass('d-none');

                $('#categoryForm').attr('action', "{{ route('contact-categories.store') }}");
                $('#methodField').val('POST');
            });

            // SweetAlert Delete
            $(document).on('click', '.btn-delete-category', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to delete this category. This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e7515a',
                    cancelButtonColor: '#3b3f5c',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endpush