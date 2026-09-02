@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

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

    <div class="text-right mb-3">
        <a href="{{ route('user.contacts.create', ['group_id' => $group->id]) }}"
           class="btn btn-primary">
            Add Contact
        </a>
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

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th width="5%">
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th width="8%">Edit</th>
                </tr>
            </thead>

            <tbody>

            @forelse($contacts as $contact)

                <tr>

                    <td>
                        <input type="checkbox"
                               name="contact_ids[]"
                               value="{{ $contact->id }}">
                    </td>

                    <td>
                        {{ $contact->contact_first_name }}
                        {{ $contact->contact_last_name }}
                    </td>

                    <td>{{ $contact->contact_email }}</td>

                    <td>{{ $contact->contact_phone }}</td>

                    <td>{{ $contact->contact_company_name }}</td>

                    <td>
                        @if($contact->status)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('user.contacts.edit', $contact) }}">
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