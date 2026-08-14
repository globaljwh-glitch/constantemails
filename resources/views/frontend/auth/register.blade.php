@extends('frontend.layouts.app')

@section('title', 'Registration')

@section('content')

<section class="contentContainer registerForm">
        <div class="container">
            <form name="frm_reg" action="" method="post" onSubmit="return Validate(this.form)">
                <div class="row">
                    <div class="col-md-7">
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
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="imageThumb text-right"><img src="images/register-thumb.jpg" alt="" class=""></div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection