@extends('admin.layouts.app')

@section('title', 'Unsubscribed Contacts | Constant Emails')

@push('styles')
    <style>
        /* =========================
                   Page Table
                ========================= */

        .unsubscribed-table {
            margin-bottom: 0 !important;
        }

        .unsubscribed-table thead th {
            background: #111827 !important;
            color: #ffffff !important;
            border: 1px solid #111827 !important;
            font-size: 13px;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 14px 15px !important;
            vertical-align: middle;
        }

        .unsubscribed-table tbody td {
            border: 1px solid #e5e7eb;
            color: #222;
            font-size: 14px;
            font-weight: 500;
            padding: 14px 15px !important;
            vertical-align: middle;
        }

        .unsubscribed-table tbody tr:hover {
            background: #f8f9fa;
        }

        .contact-name {
            color: #111827 !important;
            font-weight: 700 !important;
        }

        .contact-email {
            color: #333 !important;
            font-weight: 500;
            text-decoration: none !important;
        }

        .contact-email:hover {
            color: #111827 !important;
        }

        .contact-phone {
            color: #333;
        }


        /* =========================
                   Status Badge
                ========================= */

        .unsubscribe-badge {
            display: inline-block;
            background: #dc2626;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 11px;
            border-radius: 4px;
            letter-spacing: .2px;
        }


        /* =========================
                   Subscribe Button
                ========================= */

        .btn-subscribe {
            background: #111827;
            border: 1px solid #111827;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 15px;
            border-radius: 4px;
            transition: all .2s ease;
            min-width: 105px;
        }

        .btn-subscribe:hover,
        .btn-subscribe:focus {
            background: #000000;
            border-color: #000000;
            color: #ffffff !important;
            box-shadow: none;
        }

        .btn-subscribe i {
            margin-right: 5px;
        }


        /* =========================
                   Header Counter
                ========================= */

        .unsubscribed-count {
            background: #111827 !important;
            color: #ffffff !important;
            font-size: 12px;
            font-weight: 700;
            padding: 9px 14px;
            border-radius: 4px;
        }


        /* =========================
                   Pagination
                ========================= */

        .pagination-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .pagination-section .pagination {
            margin-bottom: 0;
        }

        .pagination-section .page-link {
            color: #111827;
            border: 1px solid #d1d5db;
            font-weight: 600;
            font-size: 13px;
            padding: 7px 12px;
        }

        .pagination-section .page-item.active .page-link {
            background: #111827;
            border-color: #111827;
            color: #ffffff;
        }

        .pagination-section .page-link:hover {
            background: #111827;
            border-color: #111827;
            color: #ffffff;
        }


        /* =========================
                   Empty State
                ========================= */

        .empty-state {
            padding: 55px 20px;
            text-align: center;
        }

        .empty-state-icon {
            width: 55px;
            height: 55px;
            margin: 0 auto 15px;
            background: #111827;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-icon i {
            font-size: 24px;
        }

        .empty-state h5 {
            color: #111827;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .empty-state p {
            color: #666;
            font-size: 13px;
        }


        /* =========================
                   Alert
                ========================= */

        .admin-alert {
            border: 0;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
        }
    </style>
@endpush


@section('content')

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-title">

            <h3>Unsubscribed Contacts</h3>

            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">

                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="flaticon-home-fill"></i>
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>

                    <li class="active">
                        <a href="#">Unsubscribed Contacts</a>
                    </li>

                </ul>
            </div>

        </div>
    </div>


    {{-- Alerts --}}
    @if(session('success'))
        <div class="row">
            <div class="col-lg-12">

                <div class="alert alert-success admin-alert mb-4">
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>

                    <strong>Success!</strong>
                    {{ session('success') }}
                </div>

            </div>
        </div>
    @endif


    @if(session('error'))
        <div class="row">
            <div class="col-lg-12">

                <div class="alert alert-danger admin-alert mb-4">
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>

                    <strong>Error!</strong>
                    {{ session('error') }}
                </div>

            </div>
        </div>
    @endif


    {{-- Main Content --}}
    <div class="row layout-spacing">

        <div class="col-lg-12">

            <div class="statbox widget box box-shadow">

                {{-- Widget Header --}}
                <div class="widget-header">

                    <div class="row align-items-center">

                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <h4>Unsubscribed Contacts</h4>
                        </div>

                        <div
                            class="col-xl-6 col-md-6 col-sm-12 d-flex justify-content-end align-items-center mt-sm-0 mt-3 pr-4">

                            <span class="unsubscribed-count">
                                {{ $contacts->total() }} Unsubscribed
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Table --}}
                <div class="widget-content widget-content-area">

                    <div class="table-responsive">

                        <table class="table table-hover text-center unsubscribed-table">

                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($contacts as $contact)

                                                            <tr>

                                                                {{-- Name --}}
                                                                <td class="text-left">
                                                                    <span class="contact-name">
                                                                        {{ trim(
                                        ($contact->contact_first_name ?? '') . ' ' .
                                        ($contact->contact_last_name ?? '')
                                    ) ?: '-' }}
                                                                    </span>
                                                                </td>


                                                                {{-- Email --}}
                                                                <td class="text-left">

                                                                    <a href="mailto:{{ $contact->contact_email }}" class="contact-email">

                                                                        {{ $contact->contact_email }}

                                                                    </a>

                                                                </td>


                                                                {{-- Phone --}}
                                                                <td>
                                                                    <span class="contact-phone">
                                                                        {{ $contact->contact_phone ?? '-' }}
                                                                    </span>
                                                                </td>


                                                                {{-- Status --}}
                                                                <td>
                                                                    <span class="unsubscribe-badge">
                                                                        Unsubscribed
                                                                    </span>
                                                                </td>


                                                                {{-- Action --}}
                                                                <td>

                                                                    <form action="{{ route('unsubscribed-contacts.subscribe', $contact->id) }}"
                                                                        method="POST" class="subscribe-form d-inline">

                                                                        @csrf

                                                                        <button type="submit" class="btn btn-subscribe" title="Subscribe contact">

                                                                            <i class="flaticon-user-check"></i>
                                                                            Subscribe

                                                                        </button>

                                                                    </form>

                                                                </td>

                                                            </tr>

                                @empty

                                    <tr>

                                        <td colspan="5">

                                            <div class="empty-state">

                                                <div class="empty-state-icon">
                                                    <i class="flaticon-user-check"></i>
                                                </div>

                                                <h5>No Unsubscribed Contacts</h5>

                                                <p class="mb-0">
                                                    There are currently no contacts who have unsubscribed.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    @if($contacts instanceof \Illuminate\Pagination\LengthAwarePaginator)

                                <div class="pagination-section">

                                    {!! $contacts
                        ->appends(request()->query())
                        ->links('pagination::bootstrap-4') !!}

                                </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {

            $('.subscribe-form').on('submit', function (e) {
                e.preventDefault();

                const form = this;

                Swal.fire({
                    title: 'Subscribe Contact?',
                    text: 'This contact will be subscribed again and can receive emails.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Subscribe',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });

        });
    </script>
@endpush