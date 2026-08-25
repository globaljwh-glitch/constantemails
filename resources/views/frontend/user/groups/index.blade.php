@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Contact Group List</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        Here you can manage your Contact Groups. You may view your contacts,
        activate them, deactivate them, or remove them from your account.
    </p>

    <form action="" method="POST">
        @csrf

        <div class="text-right mb-3">

        <button
    formaction="{{ route('user.groups.activate') }}"
    class="btn btn-success">
    Activate
</button>

<button
    formaction="{{ route('user.groups.deactivate') }}"
    class="btn btn-warning">
    Deactivate
</button>

<button
    formaction="{{ route('user.groups.bulk-delete') }}"
    onclick="return confirm('Delete selected groups?')"
    class="btn btn-danger">
    Delete
</button>


            <!-- <button type="submit" name="action" value="activate" class="btn btn-success">
                Activate
            </button>

            <button type="submit" name="action" value="deactivate" class="btn btn-warning text-white">
                Deactivate
            </button>

            <button type="submit"
                    name="action"
                    value="delete"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete selected groups?')">
                Delete
            </button> -->

           
        </div>

        <table class="table table-bordered table-hover">

            <thead class="bg84bfd8">
                <tr>
                    <th width="5%">
                        <input type="checkbox" id="checkAll">
                        
                    </th>
                    <th>Group Name</th>
                    <th>Group Category</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Number of Contacts</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Contacts</th>
                </tr>
            </thead>

            <tbody>

                @forelse($groups as $group)

                    <tr>

                        <td>
                            <input type="checkbox"
                                   name="group_ids[]"
                                   value="{{ $group->id }}">
                        </td>

                        <td>{{ $group->group_name }}</td>

                        <td>{{ $group->category->category_name ?? '-' }}</td>

                        <td class="text-center">
                            @if($group->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>

                        <td class="text-center">
                            {{ $group->contacts_count ?? 0 }}
                        </td>

                        <td class="text-center">
                            <a href="{{ route('user.groups.edit',$group->id) }}">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('user.groups.contacts', $group) }}">
                                <i class="fa fa-users"></i>
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            No Contact Groups Found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </form>

    <p>
        Were you uploading a file?
        <a href="#">Click Here</a>
    </p>

</div>

@endsection