@extends('frontend.layouts.app')

@section('title', 'My Saved Templates')

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

                                <h2>
                                    My Saved Templates
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <p class="mt-4">
                        Here is where you can view, edit, or delete templates
                        you've saved from emails you have sent, or templates
                        added by you.
                    </p>


                    {{-- =================================================
                         ACTION BUTTONS
                    ================================================== --}}

                    <div class="text-right mb-3">

                        <a
                            href="{{ route('user.saved-templates.create') }}"
                            class="btn btn-success"
                            title="Add Template"
                        >
                            Add Template
                        </a>

                        &nbsp;

                        <button
                            type="submit"
                            form="savedTemplatesForm"
                            class="btn btn-danger"
                            name="delete"
                            value="1"
                            title="Delete"
                            onclick="return confirmDeleteTemplates();"
                        >
                            Delete
                        </button>

                    </div>


                    {{-- =================================================
                         SAVED TEMPLATES FORM
                    ================================================== --}}

                    <form
                        id="savedTemplatesForm"
                        name="frm_reg"
                        action="{{ route('user.saved-templates.destroy') }}"
                        method="POST"
                    >

                        @csrf


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

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <div class="accountInfo">

                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="table-responsive">

                                        <table
                                            width="100%"
                                            cellspacing="1"
                                            cellpadding="5"
                                            style="margin:10px 0pt; border:0pt none;"
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


                                                    {{-- TEMPLATE NAME --}}
                                                    <td
                                                        width="80%"
                                                        colspan="2"
                                                        class="arial_12_000_b"
                                                    >
                                                        Template Name
                                                    </td>


                                                    {{-- VIEW / EDIT --}}
                                                    <td
                                                        width="15%"
                                                        colspan="3"
                                                        align="center"
                                                        class="arial_12_000_b"
                                                    >
                                                        View/Edit
                                                    </td>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                @forelse($templates as $template)

                                                    <tr class="bgeefbff">

                                                        {{-- =================================================
                                                             CHECKBOX
                                                        ================================================== --}}

                                                        <td width="5%">

                                                            <input
                                                                type="checkbox"
                                                                name="template_ids[]"
                                                                value="{{ $template->id }}"
                                                                class="templateCheckbox"
                                                            >

                                                        </td>


                                                        {{-- =================================================
                                                             TEMPLATE NAME
                                                        ================================================== --}}

                                                        <td
                                                            width="80%"
                                                            colspan="2"
                                                            class="arial_11_000"
                                                        >

                                                            {{ $template->template_title }}

                                                        </td>


                                                        {{-- =================================================
                                                             VIEW / EDIT
                                                        ================================================== --}}

                                                        <td
                                                            width="15%"
                                                            colspan="3"
                                                            align="center"
                                                        >

                                                            <a
                                                                href="{{ route('user.saved-templates.edit', $template) }}"
                                                                title="View/Edit"
                                                            >

                                                                <img
                                                                    src="{{ asset('assets/frontend/images/view.png') }}"
                                                                    title="View/Edit"
                                                                    alt="View/Edit"
                                                                    border="0"
                                                                >

                                                            </a>

                                                        </td>

                                                    </tr>

                                                @empty

                                                    {{-- =================================================
                                                         NO TEMPLATES
                                                    ================================================== --}}

                                                    <tr>

                                                        <td
                                                            colspan="4"
                                                            align="center"
                                                            class="error_msg"
                                                        >

                                                            <p>
                                                                You have no saved templates yet!
                                                            </p>

                                                            <p>

                                                                <a
                                                                    href="{{ route('user.saved-templates.create') }}"
                                                                >
                                                                    Would you like to add one?
                                                                </a>

                                                            </p>

                                                        </td>

                                                    </tr>

                                                @endforelse


                                                {{-- =================================================
                                                     DELETE BUTTON
                                                ================================================== --}}

                                                @if($templates->count())

                                                    <tr>

                                                        <td colspan="4">

                                                            <div
                                                                align="right"
                                                                style="margin-top:10px;"
                                                            >

                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-danger"
                                                                    name="delete"
                                                                    value="1"
                                                                    onclick="return confirmDeleteTemplates();"
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

                                </div>

                            </div>

                        </div>

                    </form>


                    {{-- =================================================
                         PAGINATION
                    ================================================== --}}

                    @if(isset($templates) && method_exists($templates, 'links'))

                        <div class="mt-3">

                            {{ $templates->links() }}

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

    const templateCheckboxes =
        document.querySelectorAll('.templateCheckbox');


    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    if (masterCheckbox) {

        masterCheckbox.addEventListener('change', function () {

            templateCheckboxes.forEach(function (checkbox) {

                checkbox.checked =
                    masterCheckbox.checked;

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SELECT ALL
    |--------------------------------------------------------------------------
    */

    templateCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            const total =
                templateCheckboxes.length;

            const checked =
                document.querySelectorAll(
                    '.templateCheckbox:checked'
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

function confirmDeleteTemplates()
{
    const selected =
        document.querySelectorAll(
            '.templateCheckbox:checked'
        );

    if (selected.length === 0) {

        alert(
            'Please select at least one template.'
        );

        return false;
    }

    return confirm(
        'Are you sure you want to delete the selected template(s)?'
    );
}

</script>

@endsection