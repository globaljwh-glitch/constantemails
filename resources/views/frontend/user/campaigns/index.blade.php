@extends('frontend.layouts.dashboard')

@section('title', 'My Email Campaigns')

@section('dashboard-content')

@once
    @if(session()->has('success'))

        <div style="position:relative;">

            <br>

            <span>
                You can check the campaign status and email statistics
                in
                <a
                    href="{{ route('user.email-stats.index') }}"
                    style="color:#0066cc; font-weight:bold;"
                >
                    Email History & Statistics
                </a>.
            </span>

        </div>

    @endif
@endonce

@endsection