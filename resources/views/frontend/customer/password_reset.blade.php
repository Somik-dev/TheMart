<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from wpocean.com/html/tf/themart/forgot.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:45 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="{{asset('front')}}/images/favicon.png">
    <title>Themart - eCommerce HTML5 Template</title>
    <link href="{{asset('front')}}/css/themify-icons.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/flaticon_ecommerce.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/animate.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/owl.theme.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/slick.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/slick-theme.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/swiper.min.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/owl.transitions.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/jquery.fancybox.css" rel="stylesheet">
    <link href="{{asset('front')}}/css/odometer-theme-default.css" rel="stylesheet">
    <link href="{{asset('front')}}/sass/style.css" rel="stylesheet">
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{asset('front')}}/images/preloader.png" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->

             <!-- login-area start -->
             <div class="tp-login-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="tp-accountWrapper" action="{{ route('password.sent') }}" method="POST">
                                @csrf
                                <div class="tp-accountInfo">
                                    <div class="tp-accountInfoHeader">
                                        <a href="index.html"><img src="{{asset('front')}}/images/logo-2.svg" alt=""> </a>
                                        <a class="tp-accountBtn" href="register.html">
                                            <span class="">Create Account</span>
                                        </a>
                                    </div>
                                    <div class="image">
                                        <img src="{{asset('front')}}/images/login.svg" alt="">
                                    </div>
                                    <div class="back-home">
                                        <a class="tp-accountBtn" href="index.html">
                                            <span class="">Back To Home</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="tp-accountForm form-style">
                                    <div class="fromTitle">
                                        <h2>Reset Password</h2>
                                        <p>Sign into your pages account</p>
                                    </div>
                                    @if (session('dontexists'))
                                    <div class="alert alert-warning mt-2">{{ session('dontexists') }}</div>
                                    @endif
                                    @if (session('success'))
                                    <div class="alert alert-warning mt-2">{{ session('success') }}</div>
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <label>Email</label>
                                            <input type="text" id="email" name="email" placeholder="demo@gmail.com">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <button type="submit" class="tp-accountBtn">Send Request</button>
                                        </div>
                                    </div>

                                    <p class="subText">Don't have an account? <a href="{{ route('customer.register') }}">Create free
                                            account</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- login-area end -->


    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{asset('front')}}/js/jquery.min.js"></script>
    <script src="{{asset('front')}}/js/bootstrap.bundle.min.js"></script>
    <!-- Plugins for this template -->
    <script src="{{asset('front')}}/js/modernizr.custom.js"></script>
    <script src="{{asset('front')}}/js/jquery.dlmenu.js"></script>
    <script src="{{asset('front')}}/js/jquery-plugin-collection.js"></script>
    <!-- Custom script for this template -->
    <script src="{{asset('front')}}/js/script.js"></script>
</body>


<!-- Mirrored from wpocean.com/html/tf/themart/forgot.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:45 GMT -->
</html>
