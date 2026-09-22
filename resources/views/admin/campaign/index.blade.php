@extends('admin.layouts.app')

@section('title', 'Manage Campaigns | Constant Emails')

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

        .campaign-name {
            color: #000000 !important;
            font-weight: 700 !important;
        }

        .table-controls {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .table-controls>li {
            display: inline-block;
            margin: 0;
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
            <h3>Manage Campaigns</h3>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li><a href="{{ route('admin.dashboard') }}"><i class="flaticon-home-fill"></i></a></li>
                    <li><a href="#">Campaigns</a></li>
                    <li class="active"><a href="#">All Campaigns</a></li>
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
                            <h4>Campaigns List</h4>
                        </div>
                        <div
                            class="col-xl-8 col-md-8 col-sm-12 col-12 d-flex justify-content-end align-items-center mt-sm-0 mt-3 pr-4">
                            <form action="{{ route('admin.campaigns.index') }}" method="GET" class="mr-3"
                                style="max-width: 300px; width: 100%;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search campaigns..."
                                        value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-dark" type="submit"
                                            style="border-radius: 0 4px 4px 0;">Search</button>
                                        @if(request('search'))
                                            <a href="{{ route('admin.campaigns.index') }}" class="btn btn-danger">Clear</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            <!-- <a href="{{ route('admin.campaigns.create') }}" class="btn btn-gradient-warning btn-rounded"
                                    style="height: 42px; line-height: 28px;">
                                    <i class="flaticon-plus"></i> Create Campaign
                                </a> -->
                        </div>
                    </div>
                </div>

                <div class="widget-content widget-content-area">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped mb-4">
                            <thead>
                                <tr>
                                    <th class="align-center" style="width: 60px;">#</th>
                                    <th>Campaign Title</th>
                                    <th>Email Subject</th>
                                    <th class="text-center">Date Created</th>
                                    <!-- <th class="text-center">Send Status</th> -->
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($campaigns as $key => $campaign)
                                    <tr>
                                        <td class="align-center">
                                            {{ ($campaigns->currentPage() - 1) * $campaigns->perPage() + $key + 1 }}
                                        </td>
                                        <td><span class="campaign-name">{{ $campaign->email_title }}</span></td>
                                        <td>{{ $campaign->email_subject ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $campaign->created_at->format('d M, Y') }}</td>
                                        <!-- <td class="text-center">
                                            @if($campaign->send_status == 1)
                                                <span
                                                    class="badge badge-success shadow-none badge-pill d-inline-flex align-items-center justify-content-center"
                                                    style="padding: 6px 12px;">
                                                    <i class="flaticon-check-fill mr-1" style="font-size: 14px;"></i> Sent
                                                </span>
                                            @else
                                                <span
                                                    class="badge badge-secondary shadow-none badge-pill d-inline-flex align-items-center justify-content-center"
                                                    style="padding: 6px 12px;">
                                                    <i class="flaticon-clock-1 mr-1" style="font-size: 14px;"></i> Not Sent
                                                </span>
                                            @endif
                                        </td> -->
                                        <td class="text-center">
                                            @php
                                                $status = $campaign->campaign_status ?? 'Draft';
                                                $badgeColor = match (strtolower($status)) {
                                                    'active', 'sent', 'completed' => 'success',
                                                    'scheduled', 'in progress', 'queued' => 'info',
                                                    'failed', 'cancelled' => 'danger',
                                                    default => 'warning'
                                                };
                                            @endphp
                                            <span
                                                class="badge badge-{{ $badgeColor }} shadow-none badge-pill">{{ ucfirst($status) }}</span>
                                        </td>
                                        <td class="align-center">
                                            <ul class="table-controls mb-0">
                                                <!-- Eye Button to View Contacts Modal -->
                                                <li>
                                                    <button type="button" class="btn-view-contacts"
                                                        data-id="{{ $campaign->id }}"
                                                        style="border: none; background: none; padding: 0;"
                                                        data-toggle="tooltip" title="View Contacts">
                                                        <i class="flaticon-view-1 fs-20 text-info"></i>
                                                    </button>
                                                </li>
                                                <!-- <li>
                                                            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}"
                                                                data-toggle="tooltip" title="Edit">
                                                                <i class="flaticon-edit-fill-2 fs-20"></i>
                                                            </a>
                                                        </li> -->
                                                <!-- <li>
                                                            <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}"
                                                                method="POST" class="d-inline delete-form">
                                                                @csrf @method('DELETE')
                                                                <button type="button" class="btn-delete-item"
                                                                    style="border: none; background: none; padding: 0;"
                                                                    data-toggle="tooltip" title="Delete">
                                                                    <i class="flaticon-delete-fill fs-20"></i>
                                                                </button>
                                                            </form>
                                                        </li> -->
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No campaigns found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-section">
                        @if(isset($campaigns) && $campaigns instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {!!$campaigns->appends(request()->query())->links('pagination::bootstrap-4') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to View Related Campaign Contacts -->
    <div class="modal fade" id="campaignContactsModal" tabindex="-1" role="dialog"
        aria-labelledby="campaignContactsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="campaignContactsModalLabel">Contacts for Campaign: <span
                            id="modalCampaignTitle" class="font-weight-bold text-primary"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Group Name</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="modalContactsTableBody">
                                <!-- Data injected via ajax -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">Close</button>
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

            // Handle SweetAlert Deletion
            $(document).on('click', '.btn-delete-item', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?', text: "This campaign will be permanently deleted!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#e7515a', cancelButtonColor: '#3b3f5c', confirmButtonText: 'Yes, delete it!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });

            // Handle View Contacts Modal Pop-up via AJAX
            $(document).on('click', '.btn-view-contacts', function () {
                let campaignId = $(this).data('id');
                let tbody = $('#modalContactsTableBody');
                let titleSpan = $('#modalCampaignTitle');

                tbody.html('<tr><td colspan="6" class="py-4 text-muted">Loading contacts...</td></tr>');
                titleSpan.text('');
                $('#campaignContactsModal').modal('show');

                $.ajax({
                    url: `/admin/campaigns/${campaignId}/contacts-json`,
                    type: 'GET',
                    success: function (response) {
                        titleSpan.text(response.campaign_title);
                        tbody.empty();

                        if (response.contacts.length > 0) {
                            response.contacts.forEach(contact => {
                                let statusBadge = contact.status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>';
                                let groupName = contact.group ? contact.group.group_name : 'N/A';
                                tbody.append(`
                                            <tr>
                                                <td><span class="font-weight-bold text-dark">${groupName}</span></td>
                                                <td>${contact.contact_first_name ?? ''} ${contact.contact_last_name ?? ''}</td>
                                                <td>${contact.contact_email ?? 'N/A'}</td>
                                                <td>${contact.contact_phone ?? 'N/A'}</td>
                                                <td>${contact.contact_company_name ?? 'N/A'}</td>
                                                <td>${statusBadge}</td>
                                            </tr>
                                        `);
                            });
                        } else {
                            tbody.html('<tr><td colspan="6" class="py-4 text-muted">No associated contacts found for this campaign.</td></tr>');
                        }
                    },
                    error: function () {
                        tbody.html('<tr><td colspan="6" class="py-4 text-danger">Failed to load contacts. Please try again.</td></tr>');
                    }
                });
            });
        });
    </script>
@endpush