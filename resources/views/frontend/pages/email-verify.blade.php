@extends('frontend.layouts.app')

@section('title', 'Privacy Policy')

@section('content')

<section class="contentContainer loginForm">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-6 col-xl-5">
        <h2>Free email address validator</h2>
         
        <p>Our free email checker ensures proper formatting and verifies the existence of the mailbox, confirming its ability to receive emails: the email validation process is completely discreet and our email verifier does not send any messages while testing email addresses.</p>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="contactForm pt-2">
          
        <form action="{{ route('email.verification.verify') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-lg-12">
              <input
                  type="email"
                  name="email"
                  id="email"
                  value="{{ old('email') }}"
                  class="form-control @error('email') is-invalid @enderror"
                  maxlength="254"
                  placeholder="Enter Email"
                  required
              >
              @error('email')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
              @enderror
            </div>
            <div class="col-sm-12 col-lg-12">
              <button type="submit" class="submitButton mb-0">
                  Verify Email
              </button>
            </div>
          </div>
        </form>


        @if(session('verification'))
            @php
                $result = session('verification');
            @endphp

            <div class="mt-4">

                @if($result['status'] === 'valid')
                    <div class="alert alert-success">
                        <strong>Email is valid.</strong>
                    </div>
                @elseif($result['status'] === 'invalid')
                    <div class="alert alert-danger">
                        <strong>Email is invalid.</strong>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <strong>Email could not be confirmed.</strong>
                    </div>
                @endif

                <table class="table table-bordered">
                    <tr>
                        <th>Email</th>
                        <td>{{ $result['email'] }}</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>{{ $result['status'] }}</td>
                    </tr>

                    <tr>
                        <th>Syntax</th>
                        <td>{{ $result['syntax_valid'] ? 'Valid' : 'Invalid' }}</td>
                    </tr>

                    <tr>
                        <th>Domain</th>
                        <td>{{ $result['domain_exists'] ? 'Exists' : 'Not Found' }}</td>
                    </tr>

                    <tr>
                        <th>MX Record</th>
                        <td>{{ $result['mx_exists'] ? 'Found' : 'Not Found' }}</td>
                    </tr>

                    <tr>
                        <th>SMTP Status</th>
                        <td>{{ $result['smtp_status'] }}</td>
                    </tr>

                    @if(!empty($result['smtp_code']))
                        <tr>
                            <th>SMTP Code</th>
                            <td>{{ $result['smtp_code'] }}</td>
                        </tr>
                    @endif

                    @if(!empty($result['mx_host']))
                        <tr>
                            <th>MX Host</th>
                            <td>{{ $result['mx_host'] }}</td>
                        </tr>
                    @endif

                    <tr>
                        <th>Message</th>
                        <td>{{ $result['message'] }}</td>
                    </tr>
                </table>

            </div>
        @endif
        </div>
      </div>
      <div class="col-md-12 col-lg-6 col-xl-7">

        <div class="imageThumb text-right"><img src="{{ asset('assets/frontend/images/login-thumb.jpg') }}" alt="" class=""></div>
      </div>
    </div>
  </div>
</section>

@endsection