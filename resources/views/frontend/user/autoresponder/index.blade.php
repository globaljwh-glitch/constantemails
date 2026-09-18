@extends('frontend.layouts.app')

@section('title', 'Autoresponders')

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
                         HEADER
                    ================================================== --}}
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="borderBottom">

                                <h2>
                                    Autoresponders
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <p class="mt-4">
                        Autoresponders is a feature that allows you to send
                        multiple emails to a contact over a period of multiple
                        days. When using Autoresponders, you have the ability
                        to schedule a time and date to send.
                    </p>

                    <p>
                        An autoresponder email can be used to send automatic
                        welcome letters when a subscriber signs up for a
                        service, joins an organization, or when there is the
                        need to configure a set of messages with updated
                        information/content to be automatically delivered to
                        your contacts in a sequence over a period of multiple
                        days.
                    </p>


                    {{-- =================================================
                         SUCCESS MESSAGE
                    ================================================== --}}

                    @if(session('success'))

                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>

                    @endif


                    {{-- =================================================
                         ERROR MESSAGE
                    ================================================== --}}

                    @if(session('error'))

                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>

                    @endif


                    {{-- =================================================
                         AUTORESPONDER FORM
                    ================================================== --}}

                    <form
                        name="frm_reg"
                        action="{{ route('user.autoresponders.destroy.bulk') }}"
                        method="POST"
                    >

                        @csrf

                        <div
                            class="mod-form"
                            style="margin: 10px 0;"
                        >

                            {{-- =================================================
                                 INFORMATION / ENABLE / DISABLE
                            ================================================== --}}

                            <div class="text-right">

                                <span class="arial_12_000">

                                    {{-- Info --}}
                                    <a
                                        href="javascript:void(0);"
                                        onclick="openAutoresponderInfo();"
                                    >
                                        <img
                                            src="{{ asset('assets/frontend/images/info icon.jpg') }}"
                                            alt="Info"
                                        >
                                    </a>

                                    <br>


                                    {{-- Enable --}}
                                    <a
                                        href="javascript:void(0);"
                                        onclick="enableSelectedAutoresponders();"
                                    >
                                        <img
                                            src="{{ asset('assets/frontend/images/red button.png') }}"
                                            alt="Enable"
                                        >
                                        Enable?
                                    </a>

                                    <br>


                                    {{-- Disable --}}
                                    <a
                                        href="javascript:void(0);"
                                        onclick="disableSelectedAutoresponders();"
                                    >
                                        <img
                                            src="{{ asset('assets/frontend/images/green button.png') }}"
                                            alt="Disable"
                                        >
                                        Disable?
                                    </a>

                                </span>

                            </div>


                            <div
                                style="height: 1px;"
                                class="mod-form-hr"
                            >
                            </div>


                            {{-- =================================================
                                 ADD AUTORESPONDER
                            ================================================== --}}

                            <div class="text-right mb-3">

                                <a
                                    href="{{ route('user.autoresponders.create') }}"
                                    class="submitButton"
                                >
                                    Add Autoresponder
                                </a>

                            </div>


                            {{-- =================================================
                                 AUTORESPONDER TABLE
                            ================================================== --}}

                            <div class="table-responsive">

                                <table
                                    width="100%"
                                    cellspacing="1"
                                    cellpadding="5"
                                    class="mod-form table"
                                    style="margin: 10px 0; border: 0;"
                                >

                                    <thead>

                                        <tr class="bg84bfd8">

                                            {{-- SELECT ALL --}}
                                            <td width="7%">

                                                <input
                                                    type="checkbox"
                                                    id="masterCheckbox"
                                                    name="master"
                                                    style="border:none;"
                                                >

                                            </td>


                                            {{-- NAME --}}
                                            <td
                                                width="35%"
                                                class="arial2_13_000"
                                            >
                                                Autoresponder Name
                                            </td>


                                            {{-- DATE --}}
                                            <td
                                                width="24%"
                                                class="arial2_13_000"
                                            >
                                                Scheduled Date
                                            </td>


                                            {{-- GROUP --}}
                                            <td
                                                width="23%"
                                                align="center"
                                                class="arial2_13_000"
                                            >
                                                Set Group
                                            </td>


                                            {{-- DATE --}}
                                            <td
                                                width="11%"
                                                align="center"
                                                class="arial2_13_000"
                                            >
                                                Set Date
                                            </td>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @forelse($autoresponders as $autoresponder)

                                            <tr class="bgeefbff">

                                                {{-- =================================================
                                                     CHECKBOX
                                                ================================================== --}}

                                                <td width="7%">

                                                    <input
                                                        type="checkbox"
                                                        name="autoresponder_ids[]"
                                                        class="autoresponderCheckbox"
                                                        value="{{ $autoresponder->id }}"
                                                    >

                                                </td>


                                                {{-- =================================================
                                                     AUTORESPONDER NAME
                                                ================================================== --}}

                                                <td
                                                    width="35%"
                                                    class="arial_11_000"
                                                >

                                                    {{ $autoresponder->auto_responder_name }}

                                                    {{-- Status --}}
                                                    @if($autoresponder->status === 'active')

                                                        <span
                                                            class="badge bg-success ml-2"
                                                        >
                                                            Active
                                                        </span>

                                                    @elseif($autoresponder->status === 'paused')

                                                        <span
                                                            class="badge bg-warning ml-2"
                                                        >
                                                            Paused
                                                        </span>

                                                    @else

                                                        <span
                                                            class="badge bg-secondary ml-2"
                                                        >
                                                            Draft
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- =================================================
                                                     SCHEDULED DATE
                                                ================================================== --}}

                                                <td
                                                    width="24%"
                                                    class="arial_11_000"
                                                >

                                                    @if($autoresponder->scheduled_at ?? null)

                                                        {{ \Carbon\Carbon::parse($autoresponder->scheduled_at)->format('d-m-Y h:i A') }}

                                                    @else

                                                        <span class="text-muted">
                                                            Not Scheduled
                                                        </span>

                                                    @endif

                                                </td>


                                                {{-- =================================================
                                                     SET GROUP
                                                ================================================== --}}

                                                <td
                                                    width="23%"
                                                    align="center"
                                                >

                                                    <a
                                                        href="{{ route('user.autoresponders.groups', $autoresponder) }}"
                                                        title="View/Edit Groups"
                                                    >

                                                        <img
                                                            src="{{ asset('assets/frontend/images/edit.gif') }}"
                                                            title="View/Edit"
                                                            alt="View/Edit"
                                                            border="0"
                                                        >

                                                    </a>

                                                </td>


                                                {{-- =================================================
                                                     SET DATE
                                                ================================================== --}}

                                                <td
                                                    width="11%"
                                                    align="center"
                                                >

                                                    <a
                                                        href="{{ route('user.autoresponders.schedule', $autoresponder) }}"
                                                        title="Set Schedule"
                                                    >

                                                        <img
                                                            src="{{ asset('assets/frontend/images/edit.gif') }}"
                                                            title="View/Edit"
                                                            alt="View/Edit"
                                                            border="0"
                                                        >

                                                    </a>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td
                                                    colspan="5"
                                                    class="text-center py-4"
                                                >

                                                    <p class="mb-2">
                                                        No autoresponders found.
                                                    </p>

                                                    <a
                                                        href="{{ route('user.autoresponders.create') }}"
                                                        class="submitButton"
                                                    >
                                                        Create Your First Autoresponder
                                                    </a>

                                                </td>

                                            </tr>

                                        @endforelse


                                        {{-- =================================================
                                             INFORMATION
                                        ================================================== --}}

                                        <tr>

                                            <td
                                                colspan="5"
                                                class="arial_8_000"
                                            >

                                                <p>

                                                    <br>
                                                    <br>

                                                    <img
                                                        src="{{ asset('assets/frontend/images/greenAttention.jpg') }}"
                                                        alt="Attention"
                                                    >

                                                    When sending autoresponders
                                                    to your contacts, make sure
                                                    you don't over-communicate
                                                    with them. In order to keep
                                                    your contacts from
                                                    unsubscribing, try not to
                                                    schedule multiple emails in
                                                    a short period of time.

                                                </p>


                                                <p>

                                                    <strong>Note:</strong>
                                                    If a contact unsubscribes
                                                    from an autoresponder,
                                                    he/she would be unsubscribing
                                                    from all emails.

                                                </p>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>


                            {{-- =================================================
                                 DELETE BUTTON
                            ================================================== --}}

                            @if($autoresponders->count())

                                <div
                                    align="right"
                                    style="margin-top: 10px;"
                                >

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                        name="delete"
                                        value="1"
                                        title="Delete"
                                        onclick="return confirmDeleteAutoresponders();"
                                    >
                                        Delete
                                    </button>

                                </div>

                            @endif

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =====================================================
     JAVASCRIPT
====================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const masterCheckbox =
        document.getElementById('masterCheckbox');

    const checkboxes =
        document.querySelectorAll('.autoresponderCheckbox');


    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    if (masterCheckbox) {

        masterCheckbox.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked =
                    masterCheckbox.checked;

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE MASTER CHECKBOX
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            const total =
                checkboxes.length;

            const checked =
                document.querySelectorAll(
                    '.autoresponderCheckbox:checked'
                ).length;

            if (masterCheckbox) {

                masterCheckbox.checked =
                    total > 0 && total === checked;

            }

        });

    });

});


/*
|--------------------------------------------------------------------------
| DELETE CONFIRMATION
|--------------------------------------------------------------------------
*/

function confirmDeleteAutoresponders()
{
    const selected =
        document.querySelectorAll(
            '.autoresponderCheckbox:checked'
        );

    if (selected.length === 0) {

        alert('Please select at least one autoresponder.');

        return false;
    }

    return confirm(
        'Are you sure you want to delete the selected autoresponder(s)?'
    );
}


/*
|--------------------------------------------------------------------------
| INFO WINDOW
|--------------------------------------------------------------------------
*/

function openAutoresponderInfo()
{
    window.open(
        '{{ route('user.autoresponders.info') }}',
        'Info',
        'width=400,height=250,menubar=no,status=no,resizable=0'
    );
}


/*
|--------------------------------------------------------------------------
| ENABLE
|--------------------------------------------------------------------------
*/

function enableSelectedAutoresponders()
{
    const selected =
        document.querySelectorAll(
            '.autoresponderCheckbox:checked'
        );

    if (selected.length === 0) {

        alert('Please select at least one autoresponder.');

        return;
    }

    alert(
        'Enable functionality will be connected to the Laravel controller.'
    );
}


/*
|--------------------------------------------------------------------------
| DISABLE
|--------------------------------------------------------------------------
*/

function disableSelectedAutoresponders()
{
    const selected =
        document.querySelectorAll(
            '.autoresponderCheckbox:checked'
        );

    if (selected.length === 0) {

        alert('Please select at least one autoresponder.');

        return;
    }

    alert(
        'Disable functionality will be connected to the Laravel controller.'
    );
}

</script>

@endsection