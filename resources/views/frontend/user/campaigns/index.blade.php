@extends('frontend.layouts.dashboard')

@section('title', 'My Email Campaigns')

@section('dashboard-content')


@if(session('success'))
    <div
        class="alert alert-success"
        style="position:relative;"
    >

        <strong>
            {{ session('success') }}
        </strong>

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

        <a
            href="javascript:void(0);"
            onclick="this.parentElement.remove();"
            style="
                position:absolute;
                right:10px;
                top:8px;
                color:#198754;
                font-size:20px;
                text-decoration:none;
            "
        >
            &times;
        </a>

    </div>
@endif

@endsection