@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="borderBottom">
        <h2>My Contact Groups</h2>
    </div>

    <p class="mt-4">
        Pick the Contact Group(s) you would like to send your Email to.
        <strong>*If you have no Contact Groups, please create one.</strong>
    </p>

    <form method="POST"
          action="{{ route('user.campaigns.groups.store',$campaign) }}">

        @csrf

        <div class="text-right mb-3">

            <button class="btn btn-success">

                Save & Next

            </button>

            <a href="{{ route('user.campaigns.edit',$campaign) }}"
               class="btn btn-warning">

                Back

            </a>

        </div>

        <table class="table table-bordered table-hover">

            <thead class="bg84bfd8">

            <tr>

                <th width="5%">
                    <input type="checkbox" id="checkAll">
                </th>

                <th>Group Name</th>

                <th width="25%">Number of Members</th>

                <th width="15%">Explore</th>

            </tr>

            </thead>

            <tbody>

            @foreach($groups as $group)

                <tr>

                    <td>

                        <input type="checkbox"
                               name="group_ids[]"
                               value="{{ $group->id }}"
                               {{ $campaign->groups->contains($group->id) ? 'checked' : '' }}>

                    </td>

                    <td>

                        {{ $group->group_name }}

                    </td>

                    <td>

                        {{ $group->contacts_count }}

                    </td>

                    <td class="text-center">

                        <a href="{{ route('user.groups.contacts.index',$group) }}">

                            <i class="fa fa-search"></i>

                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.getElementById('checkAll').addEventListener('change',function(){

    document.querySelectorAll('input[name="group_ids[]"]')
        .forEach(cb=>cb.checked=this.checked);

});

</script>

@endpush