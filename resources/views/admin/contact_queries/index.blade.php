@extends('admin.layouts.app')

@section('title', 'Contact Us Queries | Constant Emails')

@push('styles')
    <style>
        .table td, .table th {
            border-top: 1px solid #080908;
            vertical-align: middle;
        }
        .table th {
            color: #000000 !important;
            font-weight: 700 !important;
        }
        .pagination-section nav {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
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
                                            <a href="{{ route('admin.contact-queries.index') }}" class="btn btn-danger">Clear</a> 
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
                                    <th class="align-center" style="width: 50px;">#</th>
                                    <th>Name</th>
                                    <th>Email & Phone</th>
                                    <th>Organization</th>
                                    <th>Comments</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Date</th>
                                    <!-- <th class="text-center" style="width: 100px;">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($queries as $key => $q)
                                    <tr>
                                        <td class="align-center">{{ ($queries->currentPage() - 1) * $queries->perPage() + $key + 1 }}</td>
                                        <td><strong>{{ $q->first_name }} {{ $q->last_name }}</strong></td>
                                        <td>
                                            {{ $q->email }}<br>
                                            <small class="text-muted">{{ $q->phone ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $q->organization ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($q->comments, 40) }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-pill badge-{{ $q->status == 'Replied' ? 'success' : 'warning' }}">
                                                {{ ucfirst($q->status ?? 'Pending') }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($q->created_at)->format('d M, Y') }}</td>
                                        <!-- <td class="align-center">
                                            <form action="{{ route('admin.contact-queries.destroy', $q->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="button" class="btn-delete-item" style="border: none; background: none; padding: 0;" data-toggle="tooltip" title="Delete">
                                                    <i class="flaticon-delete-fill fs-20 text-danger"></i>
                                                </button>
                                            </form>
                                        </td> -->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No contact queries found.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();

            $(document).on('click', '.btn-delete-item', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?', text: "This query will be permanently deleted!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#e7515a', cancelButtonColor: '#3b3f5c', confirmButtonText: 'Yes, delete it!'
                }).then((result) => { if (result.isConfirmed) form.submit(); });
            });
        });
    </script>
@endpush