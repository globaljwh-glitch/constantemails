@extends('frontend.layouts.app')

@section('title', 'Bad Contacts Report')

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
                                    Bad Contacts Report
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <p class="mt-4">
                        Here you will find the contacts that could not be
                        imported from the files you have uploaded.
                    </p>

                    <p>
                        There are many reasons why some contacts could not be
                        extracted from your file and imported to your account.
                        Some of these reasons may be:
                    </p>


                    <ul class="listing01">

                        <li>
                            Two contacts have the same email address
                            (<em>in this case <u>one</u> is imported</em>)
                        </li>

                        <li>
                            A contact may not have an email address
                        </li>

                        <li>
                            The contact's email address may be missing the
                            "@" symbol or domain type
                            (<em>.com, .net, .org, etc...</em>)
                        </li>

                        <li>
                            Text in the email address field may not be an
                            email address, or may not have the email address
                            format
                            (<em>Email@Domain.com</em>)
                        </li>

                    </ul>


                    <p>
                        You can view the contacts that were not uploaded by
                        clicking on the
                        <img
                            src="{{ asset('assets/frontend/images/view.png') }}"
                            title="View details"
                            alt="View"
                            border="0"
                        >
                        icon.
                    </p>


                    <p>
                        <strong>Note:</strong>
                        Our system only looks for email addresses.
                        Information such as names, companies, physical
                        addresses, etc... may be duplicated or missing.
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


                    {{-- =================================================
                         VALIDATION ERRORS
                    ================================================== --}}

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- =================================================
                         REPORT TABLE
                    ================================================== --}}

                    <form
                        name="frm_reg"
                        action="{{ route('user.contacts.bad-report.delete') }}"
                        method="POST"
                    >

                        @csrf

                        <div class="table-responsive">

                            <table
                                width="100%"
                                cellspacing="1"
                                cellpadding="5"
                                style="margin:20px 0;"
                                class="mod-form table"
                            >

                                <thead>

                                    <tr class="bg84bfd8">

                                        {{-- SELECT ALL --}}
                                        <td width="5%">

                                            <input
                                                type="checkbox"
                                                id="masterCheckbox"
                                                name="master"
                                                style="border:none;"
                                            >

                                        </td>


                                        {{-- UPLOAD DATE --}}
                                        <td
                                            width="15%"
                                            class="arial_12_000_b"
                                        >
                                            Date of Upload
                                        </td>


                                        {{-- FILE NAME --}}
                                        <td
                                            width="15%"
                                            class="arial_12_000_b"
                                        >
                                            File Name
                                        </td>


                                        {{-- ADDED --}}
                                        <td
                                            width="25%"
                                            class="arial_12_000_b"
                                        >
                                            Number of added contacts
                                        </td>


                                        {{-- REJECTED --}}
                                        <td
                                            width="25%"
                                            class="arial_12_000_b"
                                        >
                                            Number of rejected contacts
                                        </td>


                                        {{-- DETAILS --}}
                                        <td
                                            width="15%"
                                            align="center"
                                            class="arial_12_000_b"
                                        >
                                            View details
                                        </td>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($reports as $report)

                                        <tr class="bgeefbff">

                                            {{-- =================================================
                                                 CHECKBOX
                                            ================================================== --}}

                                            <td width="5%">

                                                <input
                                                    type="checkbox"
                                                    name="report_ids[]"
                                                    value="{{ $report->id }}"
                                                    class="reportCheckbox"
                                                >

                                            </td>


                                            {{-- =================================================
                                                 UPLOAD DATE
                                            ================================================== --}}

                                            <td width="15%" class="arial_11_000">
                                                {{ $report->upload_date?->format('m/d/Y') ?? '-' }}
                                            </td>


                                            {{-- =================================================
                                                 FILE NAME
                                            ================================================== --}}

                                            <td
                                                width="15%"
                                                class="arial_11_000"
                                            >

                                                {{ $report->file_name }}

                                            </td>


                                            {{-- =================================================
                                                 ADDED CONTACTS
                                            ================================================== --}}

                                            <td
                                                width="25%"
                                                class="arial_11_000"
                                            >

                                                {{ $report->added }}

                                            </td>


                                            {{-- =================================================
                                                 REJECTED CONTACTS
                                            ================================================== --}}

                                            <td
                                                width="25%"
                                                class="arial_11_000"
                                            >

                                                {{ $report->rejected }}

                                            </td>


                                            {{-- =================================================
                                                 VIEW DETAILS
                                            ================================================== --}}

                                            <td
                                                width="15%"
                                                align="center"
                                            >

                                                <a
                                                    href="{{ route('user.contacts.bad-report.show', $report) }}"
                                                    title="View rejected contacts"
                                                >

                                                    <img
                                                        src="{{ asset('assets/frontend/images/view.png') }}"
                                                        title="View/Edit"
                                                        alt="View"
                                                        border="0"
                                                    >

                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        {{-- =================================================
                                             NO RECORDS
                                        ================================================== --}}

                                        <tr>

                                            <td
                                                colspan="6"
                                                align="center"
                                                class="error_msg"
                                            >

                                                <p class="mb-0">
                                                    No records yet!
                                                </p>

                                            </td>

                                        </tr>

                                    @endforelse


                                    {{-- =================================================
                                         DELETE
                                    ================================================== --}}

                                    @if($reports->count())

                                        <tr>

                                            <td colspan="6">

                                                <div
                                                    align="right"
                                                    style="margin-top:10px;"
                                                >

                                                    <button
                                                        type="submit"
                                                        class="btn btn-danger"
                                                        name="delete"
                                                        value="1"
                                                        title="Delete"
                                                        onclick="return confirmDeleteReports();"
                                                    >
                                                        Delete
                                                    </button>

                                                </div>

                                            </td>

                                        </tr>

                                    @endif

                                </tbody>

                            </table>

                        </div>

                    </form>


                    {{-- =================================================
                         PAGINATION
                    ================================================== --}}

                    @if(isset($reports) && method_exists($reports, 'links'))

                        <div class="mt-3">

                            {{ $reports->links() }}

                        </div>

                    @endif

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

    const reportCheckboxes =
        document.querySelectorAll('.reportCheckbox');


    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    if (masterCheckbox) {

        masterCheckbox.addEventListener('change', function () {

            reportCheckboxes.forEach(function (checkbox) {

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

    reportCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            const total =
                reportCheckboxes.length;

            const checked =
                document.querySelectorAll(
                    '.reportCheckbox:checked'
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

function confirmDeleteReports()
{
    const selected =
        document.querySelectorAll(
            '.reportCheckbox:checked'
        );

    if (selected.length === 0) {

        alert(
            'Please select at least one report.'
        );

        return false;
    }

    return confirm(
        'Are you sure you want to delete the selected report(s)?'
    );
}

</script>

@endsection