@extends('frontend.layouts.app')

@section('title', 'Pricing')

@section('content')

<section class="homeBanner innerBanner">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 marginAuto">
        <div class="middleContentOuter">
          <div class="verticalMiddle">
            <h1>Pricing</h1>
            <p>Alongside our UNLIMITED FREE trail package, we offer several other packages for larger clientele reach! For a monthly charge, you can choose which package fits best for your business.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="contentContainer">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
         <p>Determine which of our stand-out packages work best for you and your business by the numbers of contacts you wish to add to your emailing list! (Please see terms and conditions for billing information: we accept all major credit cards). </p>
      </div>
    </div>
    <div class="pricingList text-center">
      <!-- <div class="row">
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$9.99</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>500</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$14.99</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>1,000</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$19.99</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>2,500</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$29.00</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>5,000</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$49.00</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>10,000</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$69.99</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>25,000</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$89.99</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>50,000</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white">$149.99</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>100,000</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
        
        <div class="col-md-4 col-sm-6 col-lg-3">
          <div class="priceBlock">
            <h2 class="text-white smallHeading">Managed Accounts <br>Pricing upon request.</h2>
            <div class="priceBlockContent">
              <p>Number of Email Addresses</p>
              <h4>100,000 +</h4>
              <hr>
              <p>Number of Emails</p>
              <h4>Unlimited</h4>
            </div>
            <a href="#" class="signUpButton">Signup</a> </div>
        </div>
      </div> -->

      <div class="row">

    @foreach($packages as $package)

        @php
            $isManaged = strtolower($package->package_name) === 'managed package';
        @endphp

        <div class="col-md-4 col-sm-6 col-lg-3">

            <div class="priceBlock">

                @if($isManaged)

                    <h2 class="text-white smallHeading">
                        Managed Accounts <br>
                        Pricing upon request.
                    </h2>

                @else

                    <h2 class="text-white">
                        ${{ number_format($package->package_price, 2) }}
                    </h2>

                @endif


                <div class="priceBlockContent">

                    <p>Number of Email Addresses</p>

                    <h4>
                        @if($isManaged)
                            100,000 +
                        @else
                            {{ number_format($package->package_emails) }}
                        @endif
                    </h4>

                    <hr>

                    <p>Number of Emails</p>

                    <h4>Unlimited</h4>

                </div>

                @if(auth()->check())

                    <a href="{{ url('/user/account/upgrade-package') }}"
                      class="signUpButton">
                        Upgrade Package
                    </a>

                @else

                    <a href="{{ route('register', ['package' => $package->id]) }}"
                      class="signUpButton">
                        Signup
                    </a>

                @endif

            </div>

        </div>

    @endforeach

</div>
    </div>
  </div>
</section>

@endsection