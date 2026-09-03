@extends('frontend.layouts.app')

@section('title', 'Registration')

@section('content')

<section class="contentContainer registerForm">
    <div class="container">
        <div class="row">   


        <div class="col-lg-12">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>


            <form method="POST" action="{{ route('register.submit') }}">
                @csrf  
                    <div class="col-md-7">
                        <div class="contactForm pt-0 pr-4">
                            <div class="row">

                                <div class="col-lg-12">
                                    <h2>Registration</h2>
                                    <p>Please fill out the form with your contact information and your message.</p>
                                </div>

                                <!-- Username -->
                                <div class="col-md-6 mb-3">
                                    <input type="text"
                                        name="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Username"
                                        value="{{ old('username') }}">

                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <input type="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email"
                                        value="{{ old('email') }}">

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <input type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password"
                                        autocomplete="new-password">

                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 mb-3">
                                    <input type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        placeholder="Confirm Password"
                                        autocomplete="new-password">
                                </div>

                                <!-- Package -->
                                <div class="col-lg-9 mb-3">
                                    <select name="package_id"
                                            id="package_id"
                                            class="custom-select @error('package_id') is-invalid @enderror">

                                        <option value="">Select Package</option>

                                        @foreach($packages as $package)
                                            <option value="{{ $package->id }}"
                                                {{ old('package_id') == $package->id ? 'selected' : '' }}>

                                                {{ $package->package_name }}

                                                @if($package->package_price == 0)
                                                    (Free)
                                                @else
                                                    (${{ number_format($package->package_price,2) }}/month)
                                                @endif

                                            </option>
                                        @endforeach

                                    </select>

                                    @error('package_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- <div class="col-lg-3">
                                    <p class="small text-right pt-2">
                                        <a href="{{ route('pricing') }}" target="_blank">
                                            View Pricing
                                        </a>
                                    </p>
                                </div> -->

                                <!-- Captcha -->
                                <!-- <div class="col-lg-5 mb-3">
                                    <img id="captcha"
                                        src="{{ url('/captcha') }}"
                                        alt="CAPTCHA">

                                    <br>

                                    <a href="javascript:void(0)"
                                    onclick="reloadCaptcha()">
                                        Reload Image
                                    </a>
                                </div> -->

                                <!-- <div class="col-lg-5 mt-4 mb-3">
                                    <input type="text"
                                        name="captcha"
                                        class="form-control @error('captcha') is-invalid @enderror"
                                        placeholder="Captcha Code">

                                    @error('captcha')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> -->

                                <!-- Terms -->

                                <div class="col-lg-12 mb-4">

                                    <input
                                        type="checkbox"
                                        class="checkbox"
                                        id="terms"
                                        name="terms"
                                        value="1"
                                        {{ old('terms') ? 'checked' : '' }}>

                                    <label for="terms">
                                        I hereby opt-in and accept all Terms and Conditions of Constant Emails Inc.
                                    </label>

                                    @error('terms')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <!-- Buttons -->
                                <div class="col-lg-12">

                                    <button type="submit"
                                            class="btn btn-success">
                                        Register Now
                                    </button>

                                    <a href="{{ route('home') }}"
                                    class="btn btn-default orangeBg text-white">
                                        Cancel
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                </form>

                <!-- <script>
                function reloadCaptcha() {
                    document.getElementById('captcha').src = "{{ url('/captcha') }}?" + Date.now();
                }
                </script> -->
                <!-- <div class="col-md-7">
                <div class="contactForm pt-0 pr-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Registration</h2>
                            <p>Please fill out the form with your contact information and your message.</p>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <input type="text" name="username" id="name" maxlength="255" value="" placeholder="Username" value="">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <input type="email" name="email" id="email" maxlength="255" value="" placeholder="Email" class="">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <input type="password" name="pwd" id="password" maxlength="255" placeholder="Password" autocomplete="off">
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <input type="password" name="confirmPwd" id="confirmPassword" placeholder="Confirm Password" autocomplete="off">
                        </div>
                        <div class="col-lg-9">
                            <select name="package_id" id="select4" onChange="openPayment();" class="custom-select">

                                <option value="" selected="selected"></option>

                            </select>
                        </div>
                        <div class="col-lg-3">
                            <p class="small text-right pt-2"><a href="javascript:void(0);" onClick="window.open('price.php', 'EmailTemplate', 'status=1, height=380, toolbar=0, width=550, left=150, resizable=yes, scrollbars=yes');">View Pricing</a></p>
                        </div>
                        <div class="col-lg-12">

                        </div>
                        <div class="col-lg-5 mb-3">
                            <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
                            <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false" class="arial_13_c43e00">
                                <img src="./securimage/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0">
                            </a>
                        </div>
                        <div class="col-lg-5 mt-4">
                            <input type="text" name="captcha_code" placeholder="Captcha code" size="10" maxlength="6" />

                        </div>
                        <div class="col-lg-12">
                            <input type="checkbox" value="1" class="checkbox" id="terms" name="terms">
                            <label>I hereby opt-in and accept all terms and conditions of Constant Emails Inc.</label>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <button type="submit" value="Register" class="btn btn-success" name="register">Register Now</button>
                            <button onClick="registration.html" value="Cancel" class="btn btn-default orangeBg text-white" name="Cancel" title="Cancel">Cancel</button>
                        </div>
                    </div>
                </div> -->
            <div class="col-md-5">
                <div class="imageThumb text-right"><img src="images/register-thumb.jpg" alt="" class=""></div>
            </div>
        </div>
    </div>
</section>

@endsection