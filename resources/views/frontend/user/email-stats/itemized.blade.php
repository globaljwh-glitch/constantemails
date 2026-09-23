@extends('frontend.layouts.app')

@section('title', 'Itemized Email Report')

@section('content')

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

                    <div class="borderBottom">
                        <h2>Itemized Email Report</h2>
                    </div>

                    <p class="mt-4">
                        <strong>
                            {{ $campaign->email_title }}
                        </strong>
                    </p>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Opened</th>
                                    <th>Clicked</th>
                                    <th>Unsubscribed</th>
                                    <th>Bounced</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($recipients as $recipient)

                                    <tr>

                                        <td>
                                            {{ trim(
                                                ($recipient->contact_first_name ?? '') . ' ' .
                                                ($recipient->contact_last_name ?? '')
                                            ) ?: '-' }}
                                        </td>

                                        <td>
                                            {{ $recipient->contact_email ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $recipient->status ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $recipient->opened ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $recipient->clicked ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $recipient->unsubscribed ?? 0 }}
                                        </td>

                                        <td>
                                            {{ $recipient->bounced ?? 0 }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No recipient records found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-3">

                        <a
                            href="{{ route('user.email-stats.index') }}"
                            class="btn btn-default orangeBg text-white"
                        >
                            Back
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection