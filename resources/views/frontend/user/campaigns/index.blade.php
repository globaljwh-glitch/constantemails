@extends('frontend.layouts.dashboard')

@section('title', 'My Email Campaigns')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom d-flex justify-content-between align-items-center">
                <h2>My Email Campaigns</h2>

                <a href="{{ route('user.campaigns.create') }}"
                   class="btn btn-success">
                    <i class="fa fa-plus"></i> Create Campaign
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <p class="mt-4">
        Here you can manage all your email campaigns.
    </p>

    <table class="table table-bordered table-hover mt-3">

        <thead class="bg84bfd8">
            <tr>
                <th width="5%">#</th>
                <th>Email Campaign</th>
                <th>Subject</th>
                <th>From Name</th>
                <th>Status</th>
                <th>Created</th>
                <th width="18%" class="text-center">Actions</th>
            </tr>
        </thead>

        <tbody>

        @forelse($campaigns as $campaign)

            <tr>

                <td>{{ $loop->iteration + ($campaigns->firstItem() - 1) }}</td>

                <td>{{ $campaign->email_title }}</td>

                <td>{{ $campaign->email_subject }}</td>

                <td>{{ $campaign->from_name }}</td>

                <td>

                    @if($campaign->send_status)
                        <span class="badge badge-success">
                            Sent
                        </span>
                    @else
                        <span class="badge badge-warning">
                            Draft
                        </span>
                    @endif

                </td>

                <td>
                    {{ $campaign->created_at->format('d M Y') }}
                </td>

                <td class="text-center">

                    <a href="{{ route('user.campaigns.show',$campaign) }}"
                       class="btn btn-sm btn-info"
                       title="View">
                        <i class="fa fa-eye"></i>
                    </a>

                    <a href="{{ route('user.campaigns.edit',$campaign) }}"
                       class="btn btn-sm btn-primary"
                       title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="{{ route('user.campaigns.groups',$campaign) }}"
                       class="btn btn-sm btn-success"
                       title="Continue">
                        <i class="fa fa-play"></i>
                    </a>

                    <form action="{{ route('user.campaigns.destroy',$campaign) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this campaign?')">

                            <i class="fa fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="7" class="text-center">
                    No Email Campaigns Found.
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="mt-3">
        {{ $campaigns->links() }}
    </div>

</div>

@endsection