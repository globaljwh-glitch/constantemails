@extends('frontend.layouts.app')

@section('title', 'Email History and Statistics')

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
                                    Email History and Statistics
                                </h2>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <p class="mt-4">
                        Here is where you can check your email statistics.
                    </p>

                    <p>
                        After sending an email, this is the place to check
                        if such email was opened, bounced, forwarded, or if
                        your recipients decided not to receive anymore emails
                        from you.
                    </p>

                    <p>
                        <strong>*Tip:</strong>
                    </p>

                    <p>
                        You can narrow down your search by selecting a Contact
                        Group Category which will only display emails sent to
                        contacts of the selected category, or you may do a
                        custom search with specific details.
                    </p>

                    <p>
                        <strong>
                            *Click on the Tracking Email Name of your choice
                            to get detailed statistics on that particular email.
                        </strong>
                    </p>

                    <p>&nbsp;</p>


                    {{-- =================================================
                         ACCOUNT INFO
                    ================================================== --}}

                    <div class="accountInfo">

                        {{-- =================================================
                             CATEGORY FILTER
                        ================================================== --}}

                        <div class="contactForm">

                            <div class="row">

                                <div class="col-lg-4 col-md-6 col-sm-6">

                                    <strong>
                                        *Select Contact Group Category
                                    </strong>

                                </div>

                                <div class="col-lg-8 col-md-6 col-sm-6">

                                    <form
                                        method="GET"
                                        action="{{ route('user.email-stats.index') }}"
                                        id="categoryFilterForm"
                                    >

                                        <select
                                            name="contact_cat"
                                            id="sort_option"
                                            class="form-control"
                                            onchange="this.form.submit()"
                                        >

                                            <option value="0">
                                                All
                                            </option>

                                            @foreach($categories ?? [] as $category)

                                                <option
                                                    value="{{ $category->id }}"
                                                    {{ request('contact_cat') == $category->id ? 'selected' : '' }}
                                                >
                                                    {{ $category->name }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </form>

                                </div>

                            </div>


                            {{-- =================================================
                                 CUSTOM SEARCH LINK
                            ================================================== --}}

                            <div class="row mt-3">

                                <div class="col-lg-12">

                                    <a
                                        href="javascript:void(0);"
                                        onclick="toggleEmailFilter();"
                                        class="arial_13_c43e00"
                                    >
                                        Custom Search
                                    </a>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             CUSTOM FILTER
                        ================================================== --}}

                        <div
                            id="add_filter"
                            style="{{ request()->hasAny(['date_range', 'date_picker', 'r_range', 'r_count', 'sub', 'contact_cat2']) ? 'display:block;' : 'display:none;' }}"
                        >

                            <form
                                method="GET"
                                name="frm_filter"
                                action="{{ route('user.email-stats.index') }}"
                            >

                                <p>
                                    <strong>
                                        Search through your Email History and Statistics
                                    </strong>
                                </p>


                                <div class="contactForm">


                                    {{-- =================================================
                                         DATE
                                    ================================================== --}}

                                    <div class="row">

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            Date Email was sent:
                                        </div>


                                        <div class="col-lg-4 col-md-6 col-sm-6">

                                            <select
                                                name="date_range"
                                                class="form-control"
                                            >

                                                <option
                                                    value="before"
                                                    {{ request('date_range') === 'before' ? 'selected' : '' }}
                                                >
                                                    before
                                                </option>

                                                <option
                                                    value="after"
                                                    {{ request('date_range') === 'after' ? 'selected' : '' }}
                                                >
                                                    after
                                                </option>

                                                <option
                                                    value="between"
                                                    {{ request('date_range') === 'between' ? 'selected' : '' }}
                                                >
                                                    between
                                                </option>

                                            </select>

                                        </div>


                                        <div class="col-lg-4 col-md-6 col-sm-6">

                                            <input
                                                value="{{ request('date_picker') }}"
                                                type="text"
                                                name="date_picker"
                                                id="datepicker"
                                                class="form-control"
                                                readonly
                                            >

                                        </div>

                                    </div>


                                    {{-- =================================================
                                         RECIPIENTS
                                    ================================================== --}}

                                    <div class="row mt-3">

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            Recipients
                                        </div>


                                        <div class="col-lg-4 col-md-6 col-sm-6">

                                            <select
                                                name="r_range"
                                                class="form-control"
                                            >

                                                <option
                                                    value="least"
                                                    {{ request('r_range') === 'least' ? 'selected' : '' }}
                                                >
                                                    at least
                                                </option>

                                                <option
                                                    value="most"
                                                    {{ request('r_range') === 'most' ? 'selected' : '' }}
                                                >
                                                    at most
                                                </option>

                                                <option
                                                    value="equal"
                                                    {{ request('r_range') === 'equal' ? 'selected' : '' }}
                                                >
                                                    equal to
                                                </option>

                                            </select>

                                        </div>


                                        <div class="col-lg-4 col-md-6 col-sm-6">

                                            <input
                                                type="number"
                                                name="r_count"
                                                value="{{ request('r_count') }}"
                                                class="form-control"
                                                min="0"
                                            >

                                        </div>

                                    </div>


                                    {{-- =================================================
                                         TRACKING EMAIL NAME
                                    ================================================== --}}

                                    <div class="row mt-3">

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            Tracking Email Name:
                                        </div>


                                        <div class="col-lg-8 col-md-6 col-sm-6">

                                            <input
                                                type="text"
                                                name="sub"
                                                value="{{ request('sub') }}"
                                                class="form-control"
                                            >

                                        </div>

                                    </div>


                                    {{-- =================================================
                                         CONTACT GROUP CATEGORY
                                    ================================================== --}}

                                    <div class="row mt-3">

                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            Contact Group Category
                                        </div>


                                        <div class="col-lg-8 col-md-6 col-sm-6">

                                            <select
                                                name="contact_cat2"
                                                class="form-control"
                                            >

                                                <option value="">
                                                    All
                                                </option>

                                                @foreach($categories ?? [] as $category)

                                                    <option
                                                        value="{{ $category->id }}"
                                                        {{ request('contact_cat2') == $category->id ? 'selected' : '' }}
                                                    >
                                                        {{ $category->name }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>

                                    </div>


                                    {{-- =================================================
                                         SEARCH
                                    ================================================== --}}

                                    <div class="row mt-4">

                                        <div class="col-md-12 col-lg-12">

                                            <button
                                                type="submit"
                                                name="submit"
                                                value="Search"
                                                title="Search"
                                                class="submitButton mb-0"
                                            >
                                                Search
                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </form>

                        </div>


                        {{-- =================================================
                             EMAIL HISTORY TABLE
                        ================================================== --}}

                        <form
                            name="frm_reg"
                            method="POST"
                            action="{{ route('user.email-stats.destroy') }}"
                        >

                            @csrf

                            <div class="table-responsive">

                                <table
                                    width="100%"
                                    cellspacing="2"
                                    cellpadding="2"
                                    class="mod-form table"
                                    style="margin:5px 0; border:0;"
                                >

                                    <thead>

                                        <tr class="bg84bfd8">

                                            {{-- SELECT --}}
                                            <td
                                                height="61"
                                                align="left"
                                            >

                                                <input
                                                    type="checkbox"
                                                    id="masterCheckbox"
                                                    name="master"
                                                    style="border:none;"
                                                >

                                            </td>


                                            {{-- TRACKING EMAIL --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Track. Email Name
                                                </strong>
                                            </td>


                                            {{-- DATE --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Date
                                                </strong>
                                            </td>


                                            {{-- RECIPIENTS --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Recipients
                                                </strong>
                                            </td>


                                            {{-- OPENED --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Open/<br>
                                                    Viewed
                                                </strong>
                                            </td>


                                            {{-- CLICKED --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Clicked
                                                </strong>
                                            </td>


                                            {{-- UNSUBSCRIBED --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Unsub.
                                                </strong>
                                            </td>


                                            {{-- BOUNCED --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Bounced
                                                </strong>
                                            </td>


                                            {{-- FORWARDED --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Forwarded
                                                </strong>
                                            </td>


                                            {{-- ITEMIZED --}}
                                            <td
                                                align="left"
                                                class="arial_11_000"
                                            >
                                                <strong>
                                                    Itemized Report
                                                </strong>
                                            </td>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @forelse($campaigns ?? [] as $campaign)

                                            @php
                                                $stats = $campaign->stats ?? null;

                                                $totalRecipients =
                                                    $stats->total_user
                                                    ?? $campaign->recipients_count
                                                    ?? 0;

                                                $viewed =
                                                    $stats->viewed_user
                                                    ?? $campaign->opened_count
                                                    ?? 0;

                                                $clicked =
                                                    $stats->embed_link_click_status_user
                                                    ?? $campaign->clicked_count
                                                    ?? 0;

                                                $unsubscribed =
                                                    $stats->unsubscribed_user
                                                    ?? $campaign->unsubscribed_count
                                                    ?? 0;

                                                $bounced =
                                                    $stats->bounced_user
                                                    ?? $campaign->bounced_count
                                                    ?? 0;

                                                $forwarded =
                                                    $stats->forword_to_friend_user
                                                    ?? $campaign->forwarded_count
                                                    ?? 0;
                                            @endphp


                                            <tr class="bgeefbff">


                                                {{-- CHECKBOX --}}
                                                <td
                                                    height="46"
                                                    align="left"
                                                >

                                                    <input
                                                        type="checkbox"
                                                        name="campaign_ids[]"
                                                        class="campaignCheckbox"
                                                        value="{{ $campaign->id }}"
                                                    >

                                                </td>


                                                {{-- EMAIL TITLE --}}
                                                <td align="left">

                                                    <a
                                                        href="{{ route('user.email-stats.show', $campaign) }}"
                                                        class="arial_13_c43e00"
                                                    >
                                                        {{ $campaign->email_title }}
                                                    </a>

                                                </td>


                                                {{-- DATE --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="left"
                                                >

                                                    @if($campaign->schedule_date)

                                                        {{ \Carbon\Carbon::parse($campaign->schedule_date)->format('m/d/y') }}

                                                    @elseif($campaign->created_at)

                                                        {{ $campaign->created_at->format('m/d/y') }}

                                                    @else

                                                        -

                                                    @endif

                                                </td>


                                                {{-- RECIPIENTS --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >
                                                    {{ $totalRecipients }}
                                                </td>


                                                {{-- VIEWED --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >
                                                    {{ $viewed }}
                                                </td>


                                                {{-- CLICKED --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >
                                                    {{ $clicked }}
                                                </td>


                                                {{-- UNSUBSCRIBED --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >
                                                    {{ $unsubscribed }}
                                                </td>


                                                {{-- BOUNCED --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >
                                                    {{ $bounced }}
                                                </td>


                                                {{-- FORWARDED --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >
                                                    {{ $forwarded }}
                                                </td>


                                                {{-- ITEMIZED REPORT --}}
                                                <td
                                                    class="arial_13_000"
                                                    align="center"
                                                >

                                                    <a
                                                        href="{{ route('user.email-stats.itemized', $campaign) }}"
                                                        title="View Itemized Report"
                                                    >

                                                        <img
                                                            src="{{ asset('assets/frontend/images/view.png') }}"
                                                            border="0"
                                                            title="View"
                                                            alt="View"
                                                        >

                                                    </a>

                                                </td>

                                            </tr>


                                        @empty

                                            <tr>

                                                <td
                                                    colspan="10"
                                                    class="text-center py-5"
                                                >

                                                    <strong>
                                                        No email history found.
                                                    </strong>

                                                </td>

                                            </tr>

                                        @endforelse


                                        {{-- =================================================
                                             EXPORT / DELETE
                                        ================================================== --}}

                                        @if(($campaigns ?? collect())->count())

                                            <tr>

                                                <td
                                                    align="right"
                                                    colspan="10"
                                                >

                                                    <br>


                                                    {{-- EXPORT --}}
                                                    <div
                                                        style="float:left;"
                                                    >

                                                        <a
                                                            href="{{ route('user.email-stats.export', request()->query()) }}"
                                                            target="_blank"
                                                            class="arial_13_c43e00"
                                                            title="Export CSV"
                                                        >
                                                            Export this list to
                                                            an Excel *.csv file?
                                                        </a>

                                                    </div>


                                                    {{-- DELETE --}}
                                                    <div
                                                        style="float:right;"
                                                    >

                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger"
                                                            title="Delete"
                                                            onclick="return confirmDeleteCampaigns();"
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

                        @if(isset($campaigns) && method_exists($campaigns, 'links'))

                            <div class="mt-3">

                                {{ $campaigns->appends(request()->query())->links() }}

                            </div>

                        @endif

                    </div>

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

    /*
    |--------------------------------------------------------------------------
    | SELECT ALL
    |--------------------------------------------------------------------------
    */

    const masterCheckbox =
        document.getElementById('masterCheckbox');

    const campaignCheckboxes =
        document.querySelectorAll('.campaignCheckbox');


    if (masterCheckbox) {

        masterCheckbox.addEventListener('change', function () {

            campaignCheckboxes.forEach(function (checkbox) {

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

    campaignCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            const total =
                campaignCheckboxes.length;

            const checked =
                document.querySelectorAll(
                    '.campaignCheckbox:checked'
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
| CUSTOM SEARCH TOGGLE
|--------------------------------------------------------------------------
*/

function toggleEmailFilter()
{
    const filter =
        document.getElementById('add_filter');

    if (!filter) {
        return;
    }

    if (filter.style.display === 'none' ||
        filter.style.display === '') {

        filter.style.display = 'block';

    } else {

        filter.style.display = 'none';

    }
}


/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

function confirmDeleteCampaigns()
{
    const selected =
        document.querySelectorAll(
            '.campaignCheckbox:checked'
        );

    if (selected.length === 0) {

        alert(
            'Please select at least one email campaign.'
        );

        return false;
    }

    return confirm(
        'Are you sure you want to delete the selected email history?'
    );
}

</script>

@endsection