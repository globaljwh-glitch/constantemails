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
        Select the Database file type of the file that contains the contacts you would like to upload to your account. Every option you select has a format or sequence that must be followed in order to ensure the full extraction of all of the contacts in the file/database.
    </p>

    <p>
        Please read the instructions provided in every selection to upload your Database of contacts to our system.
    </p>

    <div class="accountInfo">

        <form action="{{ route('user.contacts.import.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="contactForm">

                {{-- Contact Group --}}
                <div class="row">
                    <div class="col-lg-4">
                        <label><strong>Select an option from the dropdown menu</strong></label>
                    </div>

                    <!-- <div class="col-lg-4">
                        <label><strong>Import Type</strong></label>
                    </div> -->

                    <div class="col-lg-6">

                        <select name="import_type" id="import_type" class="form-control" required>

                            <option value="">Select File Type</option>

                            <option value="csv">CSV File</option>

                            <!-- <option value="xls">Microsoft Excel (97-2003)</option> -->

                            <option value="xlsx">Microsoft Excel (2007+)</option>

                        </select>

                    </div>

                </div>

                <a href="{{ route('whatif.excel') }}"
                    onclick="
                        event.preventDefault();
                        const width = 620;
                        const height = 700;
                        const left = (screen.width - width) / 2;
                        const top = (screen.height - height) / 2;

                        window.open(
                            this.href,
                            'accessHelp',
                            `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`
                        );
                    "
                    class="access-help-link">
                    Is your Contact List is in Microsoft Access?
                </a>

                <!-- csv block -->
                <div id="csvInstructions" style="display: none; margin-top: 30px;">

                    <h2 style="
                        color: #ed1c24;
                        font-size: 28px;
                        font-weight: 400;
                        border-bottom: 1px solid #eee;
                        padding-bottom: 15px;
                        margin-bottom: 8px;
                    ">
                        CSV File Data Extraction
                    </h2>

                    <div style="
                        color: #555;
                        font-size: 16px;
                        margin-bottom: 25px;
                    ">
                        General Instructions
                    </div>

                    <p>
                        <strong>Step 1:</strong>
                        It is required that your file follows the header sequence (order)
                        shown in the image below, and has:
                    </p>

                    <p>
                        <b>-</b> <u>NO</u> column headings
                            (e.g., First Name, Last Name, Company, Email, etc...)
                        <b>-</b> Data <strong>ONLY</strong> on the first 6 columns of your spreadsheet.
                    </p>

                    <div style="margin: 15px 0 20px 20px;">
                        <img
                            src="{{ asset('assets/frontend/images/headerSequence.png') }}"
                            alt="CSV File Format"
                            style="
                                max-width: 530px;
                                width: 100%;
                                height: auto;
                                display: block;
                            "
                        >
                    </div>

                    <!-- <p style="font-size: 14px;">
                        <a href="{{ route('whatif.excel') }}"
                        onclick="window.open(
                            this.href,
                            'whatIfExcel',
                            'width=650,height=750,scrollbars=yes,resizable=yes'
                        ); return false;"
                        style="color: #f7941d; text-decoration: underline;">
                            What if my file does not look like this?
                        </a>
                    </p> -->

                    <p>
                        <strong>Step 2:</strong>
                        Make sure your file has the (.csv) file extension.
                    </p>

                    <p>
                        <strong>Step 3:</strong>
                        Choose a Contact Group from the drop down list to store the contacts
                        you will be importing from your file.
                    </p>

                    <p>
                        <strong>Step 4:</strong>
                        Browse your computer for the file and upload it.
                    </p>

                </div>

                <!-- xlsx block -->
                <div id="excelInstructions" style="display: none; margin-top: 30px;">

                    <h2 style="
                        color: #ed1c24;
                        font-size: 28px;
                        font-weight: 400;
                        border-bottom: 1px solid #eee;
                        padding-bottom: 15px;
                        margin-bottom: 8px;
                    ">
                        Microsoft Excel 2007-Present Data Extraction
                    </h2>

                    <div style="
                        color: #555;
                        font-size: 16px;
                        margin-bottom: 25px;
                    ">
                        General Instructions
                    </div>

                    <p>
                        <strong>Step 1:</strong>
                        It is required that your file follows the header sequence (order)
                        shown in the image below, and has:
                    </p>

                    <p>
                        <b>-</b> <u>NO</u> column headings (e.g., First Name, Last Name, Company, Email, etc...)<br>
                        <b>-</b> Data <strong>ONLY</strong> on the first 6 columns of your spreadsheet.
                    </p>

                    <div style="margin: 15px 0 20px 0;">
                        <img
                            src="{{ asset('assets/frontend/images/headerSequence.png') }}"
                            alt="Microsoft Excel 2007-Present File Format"
                            style="
                                max-width: 530px;
                                width: 100%;
                                height: auto;
                                display: block;
                            "
                        >
                    </div>

                    <!-- <p style="font-size: 14px;">
                        <a href="{{ route('whatif.excel') }}"
                        onclick="window.open(
                            this.href,
                            'whatIfExcel',
                            'width=650,height=750,scrollbars=yes,resizable=yes'
                        ); return false;"
                        style="color: #f7941d; text-decoration: underline;">
                            What if my file does not look like this?
                        </a>
                    </p> -->

                    <p>
                        <strong>Step 2:</strong>
                        Make sure your file is a spreadsheet file with the standard
                        (.xlsx) file extension.
                    </p>

                    <p>
                        <strong>Step 3:</strong>
                        Choose a Contact Group from the drop down list to store the contacts
                        you will be importing from your file.
                    </p>

                    <p>
                        <strong>Step 4:</strong>
                        Browse your computer for the file and upload it.
                    </p>

                </div>

                <br>
                <br>
                <br>
                {{-- File Type --}}
                <div class="row" id="import-type-group" style="display:none;">

                    <div class="col-lg-4">
                        <label><strong>*Select an existing Contact Group:</strong></label>
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
                        <small>Need to create a new Contact Group? <a href="{{ route('user.groups.create') }}">Click here</a></small>

                    </div>

                </div>

                {{-- Upload File --}}
                <div class="row" id="file-wrapper" style="display:none;">

                    <div class="col-lg-4">
                        <label><strong>Upload your file here:</strong></label>
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
                <div class="row" id="import-type-wrapper11" style="display:none;">

                    <div class="col-lg-10 offset-lg-4">

                        <a href="{{ asset('samples/sample_contacts.csv') }}"
                           download>

                            Download Sample CSV

                        </a>

                    </div>

                </div>

                {{-- Microsoft Access Note --}}
                <div class="row" id="import-type-wrapper3434" style="display:none;">

                    <div class="col-lg-10 offset-lg-4">

                        <small>

                            Using Microsoft Access?

                            Export your contacts as a CSV file and then upload the CSV.

                        </small>

                    </div>

                </div>

                {{-- Button --}}
                <div class="row" id="import-contact-button" style="display:none;">

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        $('#import_type').on('change', function () {

            if ($(this).val() === 'csv') {
                $('#excelInstructions').slideUp();
                $('#csvInstructions').slideDown();
                $('#import-type-group').slideDown();
                $('#file-wrapper').slideDown();
                $('#import-contact-button').slideDown();
            } else if ($(this).val() === 'xlsx') {
                $('#csvInstructions').slideUp();
                $('#excelInstructions').slideDown();
                $('#import-type-group').slideDown();
                $('#file-wrapper').slideDown();
                $('#import-contact-button').slideDown();
            } else {
                $('#excelInstructions').slideUp();
                $('#csvInstructions').slideUp();
                $('#import-type-group').slideUp();
                $('#file-wrapper').slideUp();
                $('#import-contact-button').slideUp();
            }

        });

    });
</script>