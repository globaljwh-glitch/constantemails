@extends('frontend.layouts.app')

@section('title', 'Assign Contacts')

@section('content')

<section class="contentContainer">

    <div class="container">

        <div class="row">

            {{-- =====================================================
                 SIDEBAR
            ====================================================== --}}
            <div class="col-lg-3 col-md-4">
                @include('frontend.includes.sidebar')
            </div>


            {{-- =====================================================
                 MAIN CONTENT
            ====================================================== --}}
            <div class="col-lg-9 col-md-8">

                <div class="acoountRightSection">

                    {{-- =================================================
                         PAGE HEADER
                    ================================================== --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="borderBottom">

                                <h2>Assign Contacts</h2>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <p class="mt-4">
                        This is the list of all the contacts that have been
                        added to your account. This includes contacts manually
                        added, imported from a file, and contacts that have
                        decided to join your mailing list.

                        Here you can check the status of your contacts and
                        edit their information.
                    </p>


                    <p>
                        Here you can assign contacts to one or more Contact
                        Groups. This is the place to come after importing your
                        contacts from a file.

                        You can select contacts with similar characteristics
                        and assign them to one or more Contact Groups.
                    </p>


                    <p class="arial_11_000">

                        To <strong>Assign</strong> one or more
                        <strong>contacts</strong> to a
                        <strong>Contact Group</strong>, simply check the
                        desired contacts and then select the Contact Group(s)
                        at the <strong>bottom of the page</strong>.

                    </p>


                    <p class="arial_11_000">

                        <strong>*Status</strong> refers to the availability
                        of the contact.

                        <strong>Opt-in</strong> means the contact is available
                        to receive messages from you.

                        <strong>Opt-out</strong> means the contact has decided
                        not to receive messages from you.

                    </p>


                    {{-- =================================================
                         SUCCESS MESSAGE
                    ================================================== --}}

                    @if(session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    {{-- =================================================
                         ERROR MESSAGE
                    ================================================== --}}

                    @if(session('error'))

                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>

                    @endif


                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- =================================================
                         CONTACT FORM
                    ================================================== --}}

                    <form
                        name="assign_contacts"
                        id="assign_contacts"
                        action="{{ route('user.contacts.assign') }}"
                        method="POST"
                    >

                        @csrf


                        {{-- =================================================
                             TOP ACTION BUTTONS
                        ================================================== --}}

                        <div class="text-right mb-3">

                            <button
                                type="submit"
                                name="action"
                                value="delete"
                                class="btn btn-danger"
                                title="Delete Selected Contacts"
                                onclick="return confirm('Are you sure you want to delete the selected contacts?');"
                            >
                                Delete
                            </button>


                            <a
                                href="{{ route('user.groups.index') }}"
                                class="btn btn-default orangeBg text-white"
                            >
                                Back
                            </a>

                        </div>


                        {{-- =================================================
                             CONTACT TABLE
                        ================================================== --}}

                        @if($contacts->count())

                            <div class="table-responsive">

                                <table
                                    width="100%"
                                    cellspacing="1"
                                    cellpadding="5"
                                    class="mod-form"
                                    style="margin: 10px 0; border: 0;"
                                >

                                    <thead>

                                        <tr class="bg84bfd8">

                                            <th width="6%">
                                                <input
                                                    type="checkbox"
                                                    id="selectAllContacts"
                                                    style="border:none;"
                                                >
                                            </th>

                                            <th width="18%" class="arial_12_000_b">
                                                Contact Name
                                            </th>

                                            <th width="22%" class="arial_12_000_b">
                                                Email Address
                                            </th>

                                            <th width="30%" class="arial_12_000_b text-center">
                                                Groups assigned to
                                            </th>

                                            <th width="14%" class="arial_12_000_b text-center">
                                                Status
                                            </th>

                                            <th width="10%" class="arial_12_000_b text-center">
                                                Edit
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach($contacts as $contact)

                                            <tr class="bgeefbff">

                                                {{-- Checkbox --}}
                                                <td>

                                                    <input
                                                        type="checkbox"
                                                        name="contact_ids[]"
                                                        value="{{ $contact->id }}"
                                                        class="contact-checkbox"
                                                    >

                                                </td>


                                                {{-- Contact Name --}}
                                                <td class="arial_11_000">

                                                    {{ trim(
                                                        ($contact->contact_first_name ?? '') .
                                                        ' ' .
                                                        ($contact->contact_last_name ?? '')
                                                    ) ?: '-' }}

                                                </td>


                                                {{-- Email --}}
                                                <td class="arial_11_000">

                                                    {{ $contact->contact_email }}

                                                </td>


                                                {{-- Groups --}}
                                                <td
                                                    class="arial_11_000 text-center"
                                                >

                                                    @if($contact->groups->count())

                                                        @foreach($contact->groups as $group)

                                                            <span class="badge badge-secondary mr-1">
                                                                {{ $group->group_name }}
                                                            </span>

                                                        @endforeach

                                                    @else

                                                        <span class="text-muted">
                                                            No group assigned
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- Status --}}
                                                <td
                                                    class="arial_11_000 text-center"
                                                >

                                                    @if(
                                                        isset($contact->status) &&
                                                        (
                                                            $contact->status == 'opt-in' ||
                                                            $contact->status == '1' ||
                                                            $contact->status === 1
                                                        )
                                                    )

                                                        <span class="text-success">
                                                            Opt-in
                                                        </span>

                                                    @else

                                                        <span class="text-danger">
                                                            Opt-out
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- Edit --}}
                                                <td class="text-center">

                                                    @if(Route::has('user.contacts.edit'))

                                                        <a
                                                            href="{{ route('user.contacts.edit', $contact->id) }}"
                                                            title="Edit"
                                                        >
                                                            <img
                                                                src="{{ asset('assets/frontend/images/edit.gif') }}"
                                                                alt="Edit"
                                                                border="0"
                                                            >
                                                        </a>

                                                    @else

                                                        <a href="#" title="Edit">
                                                            <img
                                                                src="{{ asset('assets/frontend/images/edit.gif') }}"
                                                                alt="Edit"
                                                                border="0"
                                                            >
                                                        </a>

                                                    @endif

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>


                            {{-- =================================================
                                 PAGINATION
                            ================================================== --}}

                            @if(method_exists($contacts, 'links'))

                                <div class="mt-3">
                                    {{ $contacts->links() }}
                                </div>

                            @endif


                            {{-- =================================================
                                 ASSIGN GROUPS
                            ================================================== --}}

                            <div class="accountInfo mt-4">

                                <div class="contactForm">

                                    <div class="row">

                                        <div class="col-lg-4 col-md-6 col-sm-6">

                                            <strong>
                                                Assign Contact(s) to Group(s):
                                            </strong>

                                        </div>


                                        <div class="col-lg-6 col-md-6 col-sm-6">

                                            <select
                                                class="mod-form-button form-control"
                                                name="group_ids[]"
                                                multiple
                                                size="4"
                                                id="group_ids"
                                            >

                                                @foreach($groups as $group)

                                                    <option
                                                        value="{{ $group->id }}"
                                                    >
                                                        {{ $group->group_name }}
                                                    </option>

                                                @endforeach

                                            </select>


                                            <button
                                                type="submit"
                                                name="action"
                                                value="assign"
                                                class="btn btn-success mt-2"
                                                title="Assign"
                                            >
                                                Assign
                                            </button>

                                        </div>

                                    </div>


                                    {{-- Back to Top --}}
                                    <div class="row mt-4">

                                        <div class="col-md-12 col-lg-12">

                                            <p>

                                                <a
                                                    href="#top"
                                                    class="arial_9_000"
                                                >
                                                    Back to top
                                                </a>

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @else

                            {{-- =================================================
                                 NO CONTACTS
                            ================================================== --}}

                            <p
                                class="error_msg text-center"
                            >
                                You have no contacts in your Contact List.
                            </p>

                        @endif

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     SELECT ALL JAVASCRIPT
========================================================= --}}

<script>

$(document).ready(function () {

    $('#selectAllContacts').on('change', function () {

        $('.contact-checkbox').prop(
            'checked',
            $(this).prop('checked')
        );

    });


    $('.contact-checkbox').on('change', function () {

        const total = $('.contact-checkbox').length;

        const checked = $('.contact-checkbox:checked').length;

        $('#selectAllContacts').prop(
            'checked',
            total === checked
        );

    });

});

</script>

@endsection