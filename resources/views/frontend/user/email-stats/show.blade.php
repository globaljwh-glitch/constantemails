@extends('frontend.layouts.app')

@section('title', 'Email Statistics')

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
                        <h2>
                            Email Statistics
                        </h2>
                    </div>

                    <div class="mt-4">

                        <h4>
                            {{ $campaign->email_title }}
                        </h4>

                        <hr>

                        <div class="row">

                            <div class="col-md-6">
                                <strong>Date:</strong>

                                @if($campaign->schedule_date)
                                    {{ \Carbon\Carbon::parse($campaign->schedule_date)->format('m/d/Y') }}
                                @elseif($campaign->created_at)
                                    {{ $campaign->created_at->format('m/d/Y') }}
                                @else
                                    -
                                @endif
                            </div>

                            <div class="col-md-6">
                                <strong>Status:</strong>
                                {{ ucfirst($campaign->campaign_status ?? '-') }}
                            </div>

                        </div>

                        <div class="row mt-4">

                            <div class="col-md-4">
                                <strong>Recipients</strong>
                                <br>
                                {{ $stats->total_user ?? 0 }}
                            </div>

                            <div class="col-md-4">
                                <strong>Opened / Viewed</strong>
                                <br>
                                {{ $stats->viewed_user ?? 0 }}
                            </div>

                            <div class="col-md-4">
                                <strong>Clicked</strong>
                                <br>
                                {{ $stats->embed_link_click_status_user ?? 0 }}
                            </div>

                        </div>

                        <div class="row mt-4">

                            <div class="col-md-4">
                                <strong>Unsubscribed</strong>
                                <br>
                                {{ $stats->unsubscribed_user ?? 0 }}
                            </div>

                            <div class="col-md-4">
                                <strong>Bounced</strong>
                                <br>
                                {{ $stats->bounced_user ?? 0 }}
                            </div>

                            <div class="col-md-4">
                                <strong>Forwarded</strong>
                                <br>
                                {{ $stats->forword_to_friend_user ?? 0 }}
                            </div>

                        </div>

                        <div class="mt-4">

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

    </div>

</section>

@endsection