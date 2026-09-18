@extends('frontend.layouts.app')

@section('title', 'Payment History')

@section('content')

    @include('frontend.includes.banner', ['title' => 'Payment History'])

    <section class="contentContainer">
        <div class="container">
            <div class="row">

                {{-- Sidebar --}}
                <div class="col-lg-3 col-md-4">
                    @include('frontend.includes.sidebar')
                </div>

                {{-- Main Content --}}
                <div class="col-lg-9 col-md-8">

                    <div class="acoountRightSection">

                        {{-- Page Header --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="borderBottom">
                                    <h2>Payment History</h2>
                                </div>
                            </div>
                        </div>

                        {{-- Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success mt-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger mt-4">
                                {{ session('error') }}
                            </div>
                        @endif


                        <div class="accountInfo mt-4">

                            <div class="contactForm">

                                {{-- Intro --}}
                                <div class="paymentHistoryIntro mb-4">
                                    <p class="mb-1">
                                        <strong>Payment History</strong>
                                    </p>

                                    <p class="mb-0">
                                        Below you can view your previous package payments
                                        and subscription transactions.
                                    </p>
                                </div>


                                {{-- Payment Table --}}
                                @if($payments->count())

                                    <div class="table-responsive">

                                        <table class="table paymentHistoryTable">

                                            <thead>
                                                <tr>
                                                    <th>
                                                        Payment Date
                                                    </th>

                                                    <th>
                                                        Payment Type
                                                    </th>

                                                    <th class="text-center">
                                                        Amount
                                                    </th>

                                                    <th class="text-center">
                                                        Status
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach($payments as $payment)

                                                    <tr>

                                                        {{-- Payment Date --}}
                                                        <td>
                                                            @if($payment->payment_date)
                                                                {{ $payment->payment_date->format('M d, Y') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>


                                                        {{-- Payment Type --}}
                                                        <td>

                                                            @if($payment->payment_type === 'registration')

                                                                <span class="paymentType registration">
                                                                    Registration
                                                                </span>

                                                            @elseif($payment->payment_type === 'upgrade')

                                                                <span class="paymentType upgrade">
                                                                    Package Upgrade
                                                                </span>

                                                            @else

                                                                <span class="paymentType">
                                                                    {{ ucfirst($payment->payment_type ?? '-') }}
                                                                </span>

                                                            @endif

                                                        </td>


                                                        {{-- Amount --}}
                                                        <td class="text-center paymentAmount">

                                                            ${{ number_format(
                                                                (float) $payment->payment_price,
                                                                2
                                                            ) }}

                                                        </td>


                                                        {{-- Status --}}
                                                        <td class="text-center">

                                                            @if($payment->status === 'active')

                                                                <span class="paymentStatus active">
                                                                    Active
                                                                </span>

                                                            @elseif($payment->status === 'deactive')

                                                                <span class="paymentStatus inactive">
                                                                    Inactive
                                                                </span>

                                                            @else

                                                                <span class="paymentStatus">
                                                                    {{ ucfirst($payment->status ?? '-') }}
                                                                </span>

                                                            @endif

                                                        </td>

                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>


                                    {{-- Pagination --}}
                                    @if($payments->hasPages())

                                        <div class="paymentPagination mt-4">
                                            {{ $payments->links() }}
                                        </div>

                                    @endif


                                @else

                                    {{-- Empty State --}}
                                    <div class="paymentEmptyState">

                                        <div class="paymentEmptyIcon">
                                            $
                                        </div>

                                        <h3>
                                            No Payment History
                                        </h3>

                                        <p>
                                            You don't have any payment history yet.
                                        </p>

                                        <p>
                                            Choose a package to get started with
                                            Constant Emails.
                                        </p>

                                        <a
                                            href="{{ route('user.account.upgrade') }}"
                                            class="submitButton"
                                        >
                                            Upgrade My Package
                                        </a>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection


@push('styles')

<style>

    /* --------------------------------
       Payment History
    -------------------------------- */

    .paymentHistoryIntro {
        color: #555;
        line-height: 1.7;
    }

    .paymentHistoryIntro strong {
        font-size: 17px;
        color: #333;
    }


    /* --------------------------------
       Table
    -------------------------------- */

    .paymentHistoryTable {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
        background: #fff;
    }

    .paymentHistoryTable thead th {
        background: #f3a03a;
        color: #fff;
        border: none;
        padding: 12px 15px;
        font-size: 14px;
        font-weight: 600;
        vertical-align: middle;
    }

    .paymentHistoryTable tbody td {
        padding: 14px 15px;
        border-bottom: 1px solid #e8e8e8;
        color: #333;
        font-size: 14px;
        vertical-align: middle;
    }

    .paymentHistoryTable tbody tr:nth-child(even) {
        background: #f7f9fb;
    }

    .paymentHistoryTable tbody tr:hover {
        background: #fff8ef;
    }


    /* --------------------------------
       Payment Type
    -------------------------------- */

    .paymentType {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 3px;
        background: #eee;
        color: #555;
        font-size: 12px;
    }

    .paymentType.registration {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .paymentType.upgrade {
        background: #fff3e0;
        color: #ef6c00;
    }


    /* --------------------------------
       Amount
    -------------------------------- */

    .paymentAmount {
        font-weight: 600;
        color: #222 !important;
        white-space: nowrap;
    }


    /* --------------------------------
       Status
    -------------------------------- */

    .paymentStatus {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        background: #eee;
        color: #555;
        font-size: 12px;
    }

    .paymentStatus.active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .paymentStatus.inactive {
        background: #ffebee;
        color: #c62828;
    }


    /* --------------------------------
       Empty State
    -------------------------------- */

    .paymentEmptyState {
        text-align: center;
        padding: 45px 25px;
        border: 1px solid #eee;
        background: #fafafa;
    }

    .paymentEmptyIcon {
        width: 55px;
        height: 55px;
        line-height: 55px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #f3a03a;
        color: #fff;
        font-size: 25px;
        font-weight: 600;
    }

    .paymentEmptyState h3 {
        margin: 0 0 8px;
        color: #333;
        font-size: 21px;
        font-weight: 600;
    }

    .paymentEmptyState p {
        margin-bottom: 7px;
        color: #777;
    }

    .paymentEmptyState .submitButton {
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
    }


    /* --------------------------------
       Pagination
    -------------------------------- */

    .paymentPagination {
        display: flex;
        justify-content: center;
    }


    /* --------------------------------
       Mobile
    -------------------------------- */

    @media (max-width: 767px) {

        .paymentHistoryTable {
            min-width: 650px;
        }

        .paymentHistoryIntro {
            margin-bottom: 20px;
        }

        .paymentEmptyState {
            padding: 35px 15px;
        }

    }

</style>

@endpush