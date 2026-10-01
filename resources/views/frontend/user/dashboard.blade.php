@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('frontend.includes.banner', [
    'title' => 'Account Details'
])
<section class="homeBanner smallPadding">
  <div class="container">
    <div class="row">
        {{-- Heading --}}
        <div class="col-lg-12">
            <h1>My Account</h1> 

            @if(session('success')) 
                <p class="text-center text-success">
                  {{ session('success') }}
                </p> 
            @endif
        </div>
    </div>
  </div>
</section>
<section class="contentContainer smallContainer">
  <div class="container">
    <div class="row">

      {{-- Sidebar --}}
      
      <div class="col-lg-3 col-md-4"> @include('frontend.includes.sidebar') </div>

      {{-- Account Content --}}
      
      <div class="col-lg-9 col-md-8">
        <style>
          .contactForm input[type="radio"] {
            height: 15px !important;
          }

          
        </style>

        <div class="acoountRightSection">
          {{-- Heading --}}
          <div class="row">
            <div class="col-lg-12">
              <div class="borderBottom">
                <h2>Profile Details</h2>
              </div>
            </div>
          </div>
          
          {{-- Account Information --}}
          <div class="accountInfo mt-4">
            {{-- Name --}}
            <div class="list ">
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <label>First Name</label>
                  <div>{{ $user->name ?? '-' }}</div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <label>Last Name</label>
                  <div class="">
                    {{ $user->name ?? '-' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="list ">
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <label>Email</label>
                  <div class="">
                    {{ $user->email ?? '-' }}
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <label>Company/Organization</label>
                  <div class="">
                    {{ $user->company_name ?? '-' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="list ">
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <label>Phone Number</label>
                  <div class="">
                    {{ $user->company_phone ?? '-' }}
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <label>Fax Number</label>
                  <div class="">
                    {{ $user->company_fax ?? '-' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="list ">
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <label>Address</label>
                  <div class="">
                    {{ $user->company_address ?? '-' }}
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <label>City/Town</label>
                  <div class="">
                    {{ $user->city ?? '-' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="list ">
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <label>State/Province</label>
                  <div class="">
                    {{ $user->state ?? '-' }}
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <label>Country</label>
                  <div class="">
                    {{ $user->country ?? '-' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="list ">
              <div class="row">
                <div class="col-md-6 col-lg-6">
                  <label>Zip/Postal Code</label>
                  <div class="">
                    {{ $user->zip ?? '-' }}
                  </div>
                </div>
                <div class="col-md-6 col-lg-6">
                  <label>Package Type</label>
                  <div class="">
                    {{ $user->package_type ?? 'Free' }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Package Information --}}
          <div class="contactForm">
            <div class="row">
              <div class="col-lg-12">
                <div class="borderBottom">
                  <h2>Package Detail</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="packageDetailBox mt-4">
                  <h4 class="mb-0">Package Type : <span class="text-red">
                      <strong>{{ $user->package_type ?? 'Free' }}</strong>
                    </span>
                  </h4>
                </div>
              </div>
            </div>
          </div>

          {{-- Storage Information --}}
          <div class="contactForm">
            <div class="row">
              <div class="col-lg-12">
                <div class="borderBottom">
                  <h2>Storage Detail</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-lg-6">
                <div class="packageDetailBox mt-4">
                  <h4>Contact Remaining</h4>
                  <h6>
                    <span class="text-red">
                      <strong>{{ $only_mail ?? 0 }}</strong>
                    </span> contacts remaining to upload.
                  </h6>
                  <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <a href="{{ route('pricing') }}" class="custom-btn1 transparent-btn">Add more emails?</a>
                </div>
              </div>
              <div class="col-md-6 col-lg-6">
                <div class="packageDetailBox mt-4">
                  <h4>Images Storage</h4>
                  <h6>
                    <span class="text-red">
                      <strong>{{ $image_storage_used ?? 0 }}MB/ {{ $image_storage_limit ?? 0 }}MB</strong>
                    </span> image gallery space.
                  </h6>
                  <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <a href="" class="custom-btn1 transparent-btn">Upload images?</a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

@endsection