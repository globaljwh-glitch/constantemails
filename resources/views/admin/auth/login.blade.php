<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Login | Constant Emails</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/assets/img/favicon.ico') }}" />

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/assets/css/users/login-2.css') }}" rel="stylesheet">

    <!-- Professional Enterprise Styles -->
    <style>
        /* Ambient Background Effect */
        body.login {
            background-color: #f8f9fa;
            /* Very clean, light background */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Top Left Warm Glow */
        body.login::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(246, 153, 63, 0.12);
            /* Matches your warning/orange theme */
            border-radius: 50%;
            top: -150px;
            left: -100px;
            filter: blur(100px);
            z-index: -1;
        }

        /* Bottom Right Cool Glow */
        body.login::after {
            content: "";
            position: absolute;
            width: 600px;
            height: 600px;
            background: rgba(56, 98, 245, 0.08);
            /* Soft enterprise blue */
            border-radius: 50%;
            bottom: -200px;
            right: -150px;
            filter: blur(120px);
            z-index: -1;
        }

        .login-card {
            background: #ffffff;
            border-radius: 12px;
            /* Enhanced shadow for floating effect over the ambient background */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 45px 40px;
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .theme-logo {
            max-width: 160px;
            height: auto;
            margin-bottom: 10px;
        }

        /* Clean Input Styling */
        .custom-input-group {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
            background-color: #fdfdfe;
        }

        .custom-input-group:focus-within {
            border-color: #f6993f;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(246, 153, 63, 0.1);
        }

        .custom-input-group .input-group-text {
            background: transparent;
            border: none;
            padding-right: 10px;
            color: #a0aec0;
        }

        .custom-input-group .form-control {
            border: none;
            box-shadow: none;
            padding-left: 0;
            background: transparent;
            height: 50px;
            font-size: 14px;
        }

        .welcome-text {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 35px;
        }

        .input-label {
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
            display: block;
        }
    </style>
</head>

<body class="login">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center">

                <!-- Login Card Wrapper -->
                <div class="login-card text-left">

                    <!-- Logo & Welcome Area -->
                    <div class="text-center mb-4">
                        <img alt="logo" src="{{ asset('assets/admin/assets/img/logo-3.jpg') }}" class="theme-logo">
                        <h4 class="mt-3 font-weight-bold" style="color: #2d3748;">Sign In</h4>
                        <p class="welcome-text">Access your admin dashboard</p>
                    </div>

                    <form class="form-login" method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <!-- Email Input -->
                        <div class="form-group mb-4">
                            <label for="inputEmail" class="input-label">Email Address</label>
                            <div class="custom-input-group @error('email') border-danger @enderror">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="icon-inputEmail">
                                        <i class="flaticon-user-7"></i>
                                    </span>
                                </div>
                                <input type="email" id="inputEmail" name="email" value="{{ old('email') }}"
                                    class="form-control" placeholder="Enter your email" required autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-2 d-block font-weight-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="form-group mb-4">
                            <label for="inputPassword" class="input-label">Password</label>
                            <div class="custom-input-group @error('password') border-danger @enderror">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="icon-inputPassword">
                                        <i class="flaticon-key-2"></i>
                                    </span>
                                </div>
                                <input type="password" id="inputPassword" name="password" class="form-control"
                                    placeholder="Enter your password" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-2 d-block font-weight-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password Row -->
                        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
                                <label class="custom-control-label text-muted" style="font-size: 14px;"
                                    for="customCheck1">Remember me</label>
                            </div>
                            <div class="forgot-pass">
                                <a href="{{ route('password.request') }}"
                                    class="text-primary text-decoration-none font-weight-bold" style="font-size: 14px;">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn-lg btn-gradient-warning btn-block mb-3 mt-4"
                            style="border-radius: 6px; font-weight: 600; padding: 12px;" type="submit">
                            Log In
                        </button>

                    </form>
                </div>
                <!-- End Login Card -->

            </div>
        </div>
    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/admin/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/admin/assets/js/loader.js') }}"></script>
    <script src="{{ asset('assets/admin/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

</body>

</html>