@extends('frontend.layouts.dashboard')

@section('dashboard-content')

<div class="acoountRightSection">

    <div class="borderBottom">
        <h2>Email Scheduling</h2>
    </div>

    <p class="mt-4">
        Decide when you want to send your email. You may send it immediately or
        schedule it for a later date and time.
    </p>

    <form action="{{ route('user.campaigns.send.store', $campaign) }}" method="POST">

        @csrf

        <div class="accountInfo">

            <div class="row mb-4">

                <div class="col-md-3">
                    <strong>Send Option</strong>
                </div>

                <div class="col-md-9">

                    <div class="form-check mb-2">

                        <input
                            class="form-check-input"
                            type="radio"
                            name="scheduler"
                            id="send_now"
                            value="send_now"
                            {{ old('scheduler', $campaign->scheduler ?? 'send_now') == 'send_now' ? 'checked' : '' }}
                        >

                        <label class="form-check-label" for="send_now">
                            Send Email Now
                        </label>

                    </div>

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="radio"
                            name="scheduler"
                            id="schedule_now"
                            value="schedule_now"
                            {{ old('scheduler', $campaign->scheduler) == 'schedule_now' ? 'checked' : '' }}
                        >

                        <label class="form-check-label" for="schedule_now">
                            Schedule Email
                        </label>

                    </div>

                </div>

            </div>

            <div id="scheduleFields"
                 style="{{ old('scheduler', $campaign->scheduler) == 'schedule_now' ? '' : 'display:none;' }}">

                <div class="row mb-3">

                    <div class="col-md-3">
                        <strong>Schedule Date</strong>
                    </div>

                    <div class="col-md-4">

                        <input
                            type="date"
                            name="schedule_date"
                            class="form-control"
                            value="{{ old('schedule_date', $campaign->schedule_date) }}">

                    </div>

                </div>

                <div class="row mb-4">

                    <div class="col-md-3">
                        <strong>Schedule Time</strong>
                    </div>

                    <div class="col-md-2">

                        <select name="schedule_hour" class="form-control">

                            @for($i=0;$i<=23;$i++)

                                <option
                                    value="{{ $i }}"
                                    {{ old('schedule_hour', $campaign->schedule_hour) == $i ? 'selected' : '' }}>
                                    {{ sprintf('%02d',$i) }}
                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select name="schedule_minute" class="form-control">

                            @for($i=0;$i<=59;$i++)

                                <option
                                    value="{{ $i }}"
                                    {{ old('schedule_minute', $campaign->schedule_minute) == $i ? 'selected' : '' }}>
                                    {{ sprintf('%02d',$i) }}
                                </option>

                            @endfor

                        </select>

                    </div>

                </div>

            </div>

            <div class="mt-4">

                <a href="{{ route('user.campaigns.editor', $campaign) }}"
                   class="btn btn-warning">
                    Back
                </a>

                <button class="btn btn-success">
                    Send
                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

function toggleScheduleFields() {

    let schedule = document.getElementById('schedule_now').checked;

    document.getElementById('scheduleFields').style.display =
        schedule ? 'block' : 'none';
}

document.getElementById('send_now').addEventListener('change', toggleScheduleFields);
document.getElementById('schedule_now').addEventListener('change', toggleScheduleFields);

toggleScheduleFields();

</script>

@endpush