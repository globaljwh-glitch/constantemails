@extends('admin.layouts.app')

@section('title', 'Contact Us Queries | Constant Emails')

@push('styles')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css">
    
    <style>
        .table td, .table th {
            border-top: 1px solid #ebedf2;
            vertical-align: middle;
            padding: 14px 16px;
        }
        .table th {
            background-color: #fafbfc;
            color: #515365 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
        }
        .query-name-link {
            color: #2196f3 !important;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.2s;
        }
        .query-name-link:hover {
            color: #0d6efd !important;
            text-decoration: underline;
        }
        .pagination-section nav {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        /* Custom SweetAlert Modal Styling */
        .swal2-popup .query-detail-box {
            text-align: left;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
            border: 1px solid #e9ecef;
        }
        .swal2-popup .query-detail-row {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .swal2-popup .query-detail-row strong {
            color: #3b3f5c;
            display: inline-block;
            width: 130px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Contact Us Queries</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Queries</a></li>
                    <li class="active"><a href="#">All Contact Queries</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    <strong>Success!</strong> {{ session('success') }}
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
                            <h4>Queries List</h4>
                        </div>
                        <div class="col-xl-8 col-md-8 col-sm-12 col-12 d-flex justify-content-end align-items-center mt-sm-0 mt-3 pr-4">
                            <form action="{{ route('admin.contact-queries.index') }}" method="GET" class="mr-3" style="max-width: 300px; width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search queries..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit" style="border-radius: 0 4px 4px 0;">Search</button>
                                        @if(request('search')) 
                                            <a href="{{ route('admin.contact-queries.index') }}" class="btn btn-danger ml-2" style="border-radius: 4px;">Clear</a> 
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-4">
                            <thead>
                                <tr>
                                    <th class="align-center" style="width: 50px;">#</th>
                                    <th>Name</th>
                                    <th>Email & Phone</th>
                                    <th>Organization</th>
                                    <th>Comments</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($queries as $key => $q)
                                    <tr>
                                        <td class="align-center">{{ ($queries->currentPage() - 1) * $queries->perPage() + $key + 1 }}</td>
                                        <td>
                                            <!-- Clickable Name Triggering Professional Popup Modal -->
                                            <a href="javascript:void(0);" 
                                               class="query-name-link"
                                               data-firstname="{{ $q->first_name }}"
                                               data-lastname="{{ $q->last_name ?? '' }}"
                                               data-email="{{ $q->email }}"
                                               data-phone="{{ $q->phone ?? 'N/A' }}"
                                               data-org="{{ $q->organization ?? 'N/A' }}"
                                               data-comments="{{ $q->comments }}"
                                               data-status="{{ ucfirst($q->status ?? 'New') }}"
                                               data-date="{{ \Carbon\Carbon::parse($q->created_at)->format('d M, Y h:i A') }}">
                                                {{ $q->first_name }} {{ $q->last_name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $q->email }}<br>
                                            <small class="text-muted">{{ $q->phone ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $q->organization ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($q->comments, 40) }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-pill badge-{{ in_array($q->status, ['replied', 'closed']) ? 'success' : 'warning' }}">
                                                {{ ucfirst($q->status ?? 'New') }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($q->created_at)->format('d M, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">No contact queries found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-section">
                        {!! $queries->appends(request()->query())->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            // On click Name open professional popup modal
            $(document).on('click', '.query-name-link', function () {
                let firstName = $(this).data('firstname');
                let lastName = $(this).data('lastname');
                let email = $(this).data('email');
                let phone = $(this).data('phone');
                let org = $(this).data('org');
                let comments = $(this).data('comments');
                let status = $(this).data('status');
                let date = $(this).data('date');

                Swal.fire({
                    title: '<span style="font-size: 20px; color: #3b3f5c;">Query Details</span>',
                    html: `
                        <div class="query-detail-box">
                            <div class="query-detail-row"><strong>Full Name:</strong> ${firstName} ${lastName}</div>
                            <div class="query-detail-row"><strong>Email Address:</strong> ${email}</div>
                            <div class="query-detail-row"><strong>Phone Number:</strong> ${phone}</div>
                            <div class="query-detail-row"><strong>Organization:</strong> ${org}</div>
                            <div class="query-detail-row"><strong>Status:</strong> <span class="badge badge-info">${status}</span></div>
                            <div class="query-detail-row"><strong>Date Submitted:</strong> ${date}</div>
                            <div class="query-detail-row" style="margin-top: 15px;"><strong>Comments / Message:</strong></div>
                            <div style="background: #fff; padding: 10px; border-radius: 6px; border: 1px solid #ced4da; margin-top: 5px; max-height: 150px; overflow-y: auto; text-align: left; font-size: 13px; color: #495057;">
                                ${comments}
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#3b3f5c',
                    width: '600px',
                    padding: '20px'
                });
            });
        });
    </script>
@endpush