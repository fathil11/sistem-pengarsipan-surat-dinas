<!DOCTYPE html>
<html lang="en">

<head>
    <title>Masuk SIPAS Dinkes Melawi</title>

    @include('common.meta')

    @include('common.favicon')

    <link rel="stylesheet" type="text/css" href="{{ asset('/login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/login/css/main.css') }}">
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('/login/images/bg-01.jpg');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <form class="login100-form validate-form p-b-33 p-t-5" action="/masuk" method="POST">
                    <span class="login100-form-title">
                        SIPAS Dinas Kesehatan Kab. Melawi
                    </span>
                    @csrf
                    @method('POST')
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="email" placeholder="User name">
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="{{ asset("/login/vendor/jquery/jquery-3.2.1.min.js") }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset("/login/vendor/animsition/js/animsition.min.js") }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset("/login/vendor/bootstrap/js/popper.js") }}"></script>
    <script src="{{ asset("/login/vendor/bootstrap/js/bootstrap.min.js") }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset("/login/vendor/select2/select2.min.js") }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset("/login/vendor/daterangepicker/moment.min.js") }}"></script>
    <script src="{{ asset("/login/vendor/daterangepicker/daterangepicker.js") }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset("/login/vendor/countdowntime/countdowntime.js") }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset("/login/js/main.js") }}"></script>

</body>

</html>
