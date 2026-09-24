@extends('frontend.layouts.dashboard')

@section('title', 'My Email Campaigns')

@section('dashboard-content')

@if(session('success'))

    <div class="campaign-success-box">

        <button
            type="button"
            class="campaign-success-close"
            onclick="this.closest('.campaign-success-box').remove();"
            aria-label="Close"
        >
            &times;
        </button>

        <div class="campaign-success-icon">
            <i class="fa fa-check"></i>
        </div>

        <div class="campaign-success-content">

            <h3>
                Campaign Queued Successfully!
            </h3>

            <p class="campaign-success-message">
                {{ session('success') }}
            </p>

            <p class="campaign-success-description">
                Your campaign has been added to the sending queue.
                You can monitor the sending progress and view detailed
                email statistics from your Email History & Statistics.
            </p>

            <div class="campaign-success-actions">

                <a
                    href="{{ route('user.email-stats.index') }}"
                    class="campaign-success-btn"
                >
                    <i class="fa fa-bar-chart"></i>
                    Email History & Statistics
                </a>

                <a
                    href="{{ route('user.campaigns.index') }}"
                    class="campaign-success-link"
                >
                    View My Campaigns
                </a>

            </div>

        </div>

    </div>

@endif


<style>

.campaign-success-box {
    position: relative;
    display: flex;
    align-items: flex-start;
    width: 100%;
    margin-bottom: 30px;
    padding: 28px 45px 28px 30px;

    background: linear-gradient(
        135deg,
        #e8f8ee 0%,
        #d8f3e2 100%
    );

    border: 1px solid #b7e4c7;
    border-left: 6px solid #28a745;
    border-radius: 8px;

    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.12);
}


/* Check icon */

.campaign-success-icon {
    flex: 0 0 58px;
    width: 58px;
    height: 58px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-right: 20px;

    background: #28a745;
    color: #fff;

    border-radius: 50%;

    font-size: 28px;

    box-shadow: 0 4px 10px rgba(40, 167, 69, 0.25);
}


/* Content */

.campaign-success-content {
    flex: 1;
}

.campaign-success-content h3 {
    margin: 2px 0 8px;

    color: #176b2c;

    font-size: 24px;
    font-weight: 600;
}

.campaign-success-message {
    margin: 0 0 8px;

    color: #245b32;

    font-size: 16px;
    font-weight: 600;
}

.campaign-success-description {
    margin: 0 0 20px;

    color: #45634c;

    font-size: 14px;
    line-height: 1.6;
}


/* Buttons */

.campaign-success-actions {
    display: flex;
    align-items: center;
    gap: 18px;
}

.campaign-success-btn {
    display: inline-block;

    padding: 10px 18px;

    background: #28a745;
    color: #fff !important;

    border-radius: 5px;

    font-size: 14px;
    font-weight: 600;

    text-decoration: none;

    transition: all .2s ease;
}

.campaign-success-btn:hover {
    background: #218838;
    color: #fff !important;

    text-decoration: none;

    transform: translateY(-1px);
}

.campaign-success-link {
    color: #176b2c !important;

    font-size: 14px;
    font-weight: 600;

    text-decoration: underline;
}

.campaign-success-link:hover {
    color: #0f4d20 !important;
}


/* Close */

.campaign-success-close {
    position: absolute;

    top: 12px;
    right: 15px;

    border: 0;
    background: transparent;

    color: #3d7a4b;

    font-size: 25px;
    line-height: 1;

    cursor: pointer;

    opacity: .7;
}

.campaign-success-close:hover {
    opacity: 1;
}


/* Mobile */

@media (max-width: 600px) {

    .campaign-success-box {
        padding: 22px 30px 22px 20px;
    }

    .campaign-success-icon {
        flex: 0 0 45px;
        width: 45px;
        height: 45px;

        margin-right: 12px;

        font-size: 20px;
    }

    .campaign-success-content h3 {
        font-size: 19px;
    }

    .campaign-success-actions {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

</style>

@endsection