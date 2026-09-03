@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="row">
        <div class="col-lg-12">
            <div class="borderBottom">
                <h2>Import Contacts</h2>
            </div>
        </div>
    </div>

    <p class="mt-4">
        Select the file format that contains the contacts you want to import into your contact group.
    </p>

    <p>
        Please ensure your file follows the required format before importing. Download the sample file if needed.
    </p>

    <div class="accountInfo">

        <form action="{{ route('user.contacts.import.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="contactForm">

                {{-- Contact Group --}}
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label><strong>Contact Group</strong></label>
                    </div>

                    <div class="col-lg-6">

                        <select name="group_id" class="form-control" required>

                            <option value="">Select Group</option>

                            @foreach($groups as $group)

                                <option value="{{ $group->id }}">
                                    {{ $group->group_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>
                </div>

                {{-- File Type --}}
                <div class="row mb-3">

                    <div class="col-lg-4">
                        <label><strong>Import Type</strong></label>
                    </div>

                    <div class="col-lg-6">

                        <select name="import_type" class="form-control" required>

                            <option value="">Select File Type</option>

                            <option value="csv">CSV File</option>

                            <option value="xls">Microsoft Excel (97-2003)</option>

                            <option value="xlsx">Microsoft Excel (2007+)</option>

                        </select>

                    </div>

                </div>

                {{-- Upload File --}}
                <div class="row mb-3">

                    <div class="col-lg-4">
                        <label><strong>Select File</strong></label>
                    </div>

                    <div class="col-lg-6">

                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".csv,.xls,.xlsx"
                               required>

                    </div>

                </div>

                {{-- Sample File --}}
                <div class="row mb-3">

                    <div class="col-lg-10 offset-lg-4">

                        <a href="{{ asset('samples/sample_contacts.csv') }}"
                           download>

                            Download Sample CSV

                        </a>

                    </div>

                </div>

                {{-- Microsoft Access Note --}}
                <div class="row mb-3">

                    <div class="col-lg-10 offset-lg-4">

                        <small>

                            Using Microsoft Access?

                            Export your contacts as a CSV file and then upload the CSV.

                        </small>

                    </div>

                </div>

                {{-- Button --}}
                <div class="row">

                    <div class="col-lg-10 offset-lg-4">

                        <button class="submitButton">

                            Import Contacts

                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection