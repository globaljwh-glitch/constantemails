@extends('admin.layouts.app')

@section('title', 'Manage Packages | Constant Emails')

@push('styles')
    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <style>
        .table td,
        .table th {
            border-top: 1px solid #080908;
            vertical-align: middle;
        }

        /* Make Table Headers Black and Bold */
        .table th {
            color: #000000 !important;
            font-weight: 700 !important;
        }

        /* Make Package Name Black and Bold */
        .package-name {
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

        .table-controls>li>a:hover i.flaticon-edit-fill-2 {
            color: #00b1f4;
        }

        /* Info Blue on hover */
        .table-controls>li>button:hover i.flaticon-delete-fill {
            color: #e7515a;
        }

        /* Danger Red on hover */

        /* Badge styling to make statuses pop */
        .badge {
            font-weight: 600;
            padding: 6px 10px;
        }

        .price-text {
            font-weight: 700;
            color: #3b3f5c;
        }

        /* Modal specific styling */
        .modal-content {
            border: none;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
        }

        .modal-title {
            font-weight: 700;
            color: #3b3f5c;
        }

        .form-control,
        .custom-select {
            border: 1px solid #ccc;
            color: #888ea8;
            font-size: 15px;
            height: 44px;
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
    </style>
    <!-- END PAGE LEVEL CUSTOM STYLES -->
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Manage Packages</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Packages</a></li>
                    <li class="active"><a href="#">All Packages</a> </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Flash Messages & Validation Errors -->
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

            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row layout-spacing">
        <div class="col-lg-12 col-md-12 col-12 layout-spacing">

            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                            <h4>Registered Packages</h4>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-6 col-6 text-right align-self-center pr-4">
                            <!-- Trigger Add Modal Button -->
                            <a href="{{ route('admin.createpackage') }}" class="btn btn-gradient-warning btn-rounded">
                                <i class="flaticon-plus"></i> Add New Package
                            </a>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-4">
                            <thead>
                                <tr>
                                    <th class="align-center">#</th>
                                    <th>Package Name</th>
                                    <th>Stripe ID</th>
                                    <th>Price</th>
                                    <th class="text-center">Emails Allowed</th>
                                    <th class="text-center">Duration</th>
                                    <th class="text-center">Access Level</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $key => $package)
                                    <tr>
                                        <td class="align-center">{{ $key + 1 }}</td>
                                        <td><span class="package-name">{{ $package->package_name }}</span></td>
                                        <td><span class="text-muted">{{ $package->stripe_id ?? 'N/A' }}</span></td>
                                        <td class="price-text">${{ number_format($package->package_price, 2) }}</td>
                                        <td class="text-center">{{ number_format($package->package_emails) }}</td>
                                        <td class="text-center">{{ $package->duration }} Months</td>

                                        <td class="text-center">
                                            @if($package->access_level == 'admin')
                                                <span class="badge badge-dark shadow-none badge-pill">Admin</span>
                                            @else
                                                <span class="badge badge-secondary shadow-none badge-pill">User</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if($package->status == 'Active')
                                                <span class="badge badge-success shadow-none badge-pill">Active</span>
                                            @elseif($package->status == 'Deactive')
                                                <span class="badge badge-warning shadow-none badge-pill">Deactive</span>
                                            @else
                                                <span class="badge badge-danger shadow-none badge-pill">Deleted</span>
                                            @endif
                                        </td>

                                        <td class="align-center">
                                            <ul class="table-controls mb-0">
                                                <!-- Edit Button -->
                                                <li>
                                                    <a href="javascript:void(0);" class="btn-edit-package"
                                                        data-id="{{ $package->id }}" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="flaticon-edit-fill-2 fs-20"></i>
                                                    </a>
                                                </li>
                                                <!-- Delete Form & Button -->
                                                <li>
                                                    <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                                        class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn-delete-package"
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
                                        <td colspan="9" class="text-center">No packages found. Click "Add New Package" to create
                                            one.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- ADD / EDIT PACKAGE MODAL -->
    <div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packageModalLabel">Add New Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="packageForm" action="{{ route('packages.store') }}" method="POST">
                    @csrf
                    <!-- Dynamic method for updates -->
                    <input type="hidden" name="_method" id="methodField" value="POST">

                    <div class="modal-body p-4">
                        <div class="row">
                            <!-- Package Name -->
                            <div class="col-md-6">
                                <label for="packageName">Package Name <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-notes"></i></span>
                                    </div>
                                    <input type="text" id="packageName" name="package_name"
                                        class="form-control-rounded-right form-control" placeholder="e.g. Professional Plan"
                                        required>
                                </div>
                            </div>

                            <!-- Stripe ID (Readonly) -->
                            <div class="col-md-6">
                                <label for="stripeId">Stripe ID</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-credit-card"></i></span>
                                    </div>
                                    <input type="text" id="stripeId" name="stripe_id"
                                        class="form-control-rounded-right form-control"
                                        placeholder="Auto-generated by Stripe" readonly>
                                </div>
                            </div>

                            <!-- Package Price -->
                            <div class="col-md-6">
                                <label for="packagePrice">Package Price</label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" id="packagePrice" name="package_price"
                                        class="form-control" placeholder="0.00">
                                    <div class="input-group-append">
                                        <span class="form-control-rounded-right input-group-text">USD</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Package Emails Allowed -->
                            <div class="col-md-6">
                                <label for="packageEmails">No. of Emails Allowed <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-mail-fill"></i></span>
                                    </div>
                                    <input type="number" id="packageEmails" name="package_emails"
                                        class="form-control-rounded-right form-control" placeholder="e.g. 10000" value="0"
                                        required>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6">
                                <label for="duration">Duration <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-calendar-1"></i></span>
                                    </div>
                                    <input type="number" id="duration" name="duration" class="form-control"
                                        placeholder="e.g. 12" value="0" required>
                                    <div class="input-group-append">
                                        <span class="form-control-rounded-right input-group-text">Months</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Access Level -->
                            <div class="col-md-6">
                                <label for="accessLevel">Access Level <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-user-11"></i></span>
                                    </div>
                                    <select class="form-control form-control-rounded-right custom-select" id="accessLevel"
                                        name="access_level" required>
                                        <option value="user" selected>User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="form-control-rounded-left input-group-text"><i
                                                class="flaticon-power-button"></i></span>
                                    </div>
                                    <select class="form-control form-control-rounded-right custom-select" id="status"
                                        name="status" required>
                                        <option value="Active" selected>Active</option>
                                        <option value="Deactive">Deactive</option>
                                        <option value="Deleted">Deleted</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-dark btn-rounded" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-warning btn-rounded" id="submitBtn">Save
                            Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

@endsection

@push('scripts')
    <!-- SweetAlert2 CDN for Professional Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
    <script>
        $(document).ready(function () {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Setup for "Add New Package" Modal
            $('#btnAddPackage').on('click', function () {
                $('#packageModalLabel').text('Add New Package');
                $('#packageForm').attr('action', '{{ route('packages.store') }}');
                $('#methodField').val('POST');
                $('#submitBtn').text('Save Package');

                // Clear the form fields
                $('#packageForm')[0].reset();
                $('#stripeId').val(''); // Ensure Stripe ID is empty when creating a new package
            });

            // Setup for "Edit Package" Modal via AJAX
            $('.btn-edit-package').on('click', function () {
                let packageId = $(this).data('id');

                // Construct the URLs
                let editUrl = "{{ route('packages.edit', ':id') }}".replace(':id', packageId);
                let updateUrl = "{{ route('packages.update', ':id') }}".replace(':id', packageId);

                // Fetch data via AJAX
                $.get(editUrl, function (response) {
                    if (response.success) {
                        let data = response.data;

                        // Update Modal Title & Form Action
                        $('#packageModalLabel').text('Edit Package');
                        $('#packageForm').attr('action', updateUrl);
                        $('#methodField').val('PUT'); // Change method to PUT for updates
                        $('#submitBtn').text('Update Package');

                        // Populate the input fields
                        $('#packageName').val(data.package_name);
                        $('#stripeId').val(data.stripe_id); // Populate the readonly Stripe ID
                        $('#packagePrice').val(data.package_price);
                        $('#packageEmails').val(data.package_emails);
                        $('#duration').val(data.duration);
                        $('#accessLevel').val(data.access_level);
                        $('#status').val(data.status);

                        // Show the Modal
                        $('#packageModal').modal('show');
                    }
                }).fail(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error retrieving package data. Please try again.',
                        confirmButtonColor: '#e7515a'
                    });
                });
            });

            // Professional SweetAlert Delete Confirmation
            $('.btn-delete-package').on('click', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to delete this package. This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e7515a', // Theme danger red
                    cancelButtonColor: '#3b3f5c',  // Theme dark
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true // Puts confirm button on the right visually
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->
@endpush