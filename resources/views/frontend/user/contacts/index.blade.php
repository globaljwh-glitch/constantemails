@extends('frontend.layouts.dashboard')

@php
    $pageTitle = 'Contact List';
@endphp

@section('dashboard-content')

<div class="acoountRightSection contactAccountSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Contact List - {{ $group->group_name }}</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        Here you can manage all contacts in this group.
    </p>

    <!-- <div class="text-right mb-3">
        <a href="{{ route('user.contacts.create', ['group_id' => $group->id]) }}"
           class="btn btn-primary">
            Add Contact
        </a>
    </div> -->

    <div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <!-- <a href="{{ url()->previous() }}"
        class="btn btn-default orangeBg text-white">
            Back
        </a> -->

        <a href="{{ session()->has('campaign_draft')
                ? route('user.campaigns.groups', [
                    'campaign' => session('campaign_draft.campaign_id')
                ])
                : route('user.groups.index') }}"
        class="btn btn-default orangeBg text-white">
            Back
        </a>
</div>
<div>
        <a href="{{ route('user.campaigns.create') }}"
        class="btn btn-primary">
            Create Campaign
        </a>
        <a href="{{ route('user.contacts.create', ['group_id' => $group->id]) }}"
        class="btn btn-primary">
            Add Contact
        </a>
</div>
    </div>

    <form method="POST">
        @csrf

        <div class="text-right mb-3">

            <button
                formaction="{{ route('user.contacts.activate') }}"
                class="btn btn-success">
                Activate
            </button>

            <button
                formaction="{{ route('user.contacts.deactivate') }}"
                class="btn btn-warning">
                Deactivate
            </button>

            <button
                formaction="{{ route('user.contacts.bulk-delete') }}"
                onclick="return confirm('Delete selected contacts?')"
                class="btn btn-danger">
                Delete
            </button>

        </div>

        <style>
            .tableOuterBox table td {
                font-size: 13px;
            }
            .tableOuterBox table th {
                font-size: 13px;
            }
        </style>

        <div class="tableOuterBox">
        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th width="3%">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th width="3%">#</th>
                    <th width="16%">Name</th>
                    <th width="">Email</th>
                    <th width="13%">Phone</th>
                    <th width="18%">Company</th>
                    <th width="6%">Status</th>
                    <th width="3%">Edit</th>
                </tr>
            </thead>

            <tbody>
            @php
            $serial_number = 1;
            @endphp
            @forelse($contacts as $contact)

                <tr>

                    <td>
                        <input type="checkbox"
                               name="contact_ids[]"
                               value="{{ $contact->id }}">
                    </td>
                    <td>
                        {{ $serial_number++ }}
                    </td>
                    <td>
                        {{ $contact->contact_first_name }}
                        {{ $contact->contact_last_name }}
                    </td>

                    <td>{{ $contact->contact_email }}</td>

                    <td>{{ $contact->contact_phone }}</td>

                    <td>{{ $contact->contact_company_name }}</td>

                    <td align="center">
                        @if($contact->status)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <!-- <a href="{{ route('user.contacts.edit', $contact) }}">
                            <i class="fa fa-edit"></i>
                        </a> -->
                        <a href="{{ route('user.contacts.edit', [
                            'contact' => $contact->id,
                            'group_id' => $group->id
                        ]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No Contacts Found.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>
        </div>
    </form>

    {{ $contacts->links() }}

    
</div>

<script>
document.getElementById('checkAll').addEventListener('click', function () {
    document.querySelectorAll('input[name="contact_ids[]"]').forEach(function (checkbox) {
        checkbox.checked = event.target.checked;
    });
});
</script>

@endsection