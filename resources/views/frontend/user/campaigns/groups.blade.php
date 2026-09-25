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
          action="{{ route('user.campaigns.groups.store',$campaign) }}" id="templateForm">

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
                <th width="25%">Created Date</th>

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
                    <td>

                        {{ $group->created_at->format('M d, Y') }}

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

<style>

.constant-email-alert {
    border-radius: 10px;
    padding: 25px;
}

.constant-email-alert-title {
    color: #333;
    font-size: 23px;
}

.constant-email-alert-button {
    border-radius: 5px !important;
    padding: 10px 30px !important;
    font-weight: 600 !important;
}

</style>

@endsection

@push('scripts')

<script>

document.getElementById('checkAll').addEventListener('change',function(){

    document.querySelectorAll('input[name="group_ids[]"]')
        .forEach(cb=>cb.checked=this.checked);

});

</script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showValidation(title, message) {

            Swal.fire({
                icon: 'warning',
                title: title,
                html: message,
                confirmButtonText: 'OK',

                confirmButtonColor: '#f79432',

                background: '#ffffff',

                customClass: {
                    popup: 'constant-email-alert',
                    title: 'constant-email-alert-title',
                    confirmButton: 'constant-email-alert-button'
                },

                allowOutsideClick: false
            });

        }

        $('#templateForm').on('submit', function (e) {

            const selectedTemplate =
                $('input[name="group_ids[]"]:checked');

            if (selectedTemplate.length === 0) {

                e.preventDefault();

                showValidation(
                    'Group Required',
                    'Please select atleast 1 group before continuing.'
                );

                return false;
            }

            // No e.preventDefault()
            // Form submits normally and Laravel redirects.
        });

    </script>
@endpush