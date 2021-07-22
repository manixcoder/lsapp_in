<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon content -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/insightapp') }}/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/insightapp') }}/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/insightapp') }}/images/favicon-16x16.png">
    <!--Sweetalert-->
    <link rel="stylesheet" href="{{asset('public/css/sweetalert/sweetalert.min.css')}}">
    <!-- <link rel="manifest" href="{{ asset('public') }}/site.webmanifest"> -->
    <link rel="mask-icon" href="{{ asset('public/insightapp') }}/images/safari-pinned-tab.svg" color="#0078d7">
    <meta name="msapplication-TileColor" content="#0078d7">
    <meta name="theme-color" content="#0078d7">

    <!-- Bootstrap 4.3.1 -->
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"-->
    <link rel="stylesheet" href="{{ asset('public/insightapp/css/bootstrap/bootstrap-4.3.1.min.css') }}">

    <!-- Main stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/insightapp/css/style.css') }}">


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-134698258-1"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <!-- <script src="https://js.stripe.com/v2/"></script> -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-134698258-1');
    </script>


    <title>@yield('pageTitle')</title>

    <meta name="description" content="Insight is a communication tool that connects you to people who have a problem to solve. Lend your expertise and empower people to do great things.">
    <link rel="canonical" href="https://www.insightapp.co/">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    

    

    <!-- include Page CSS -->
    @yield('pageCss')
     
</head>

<body class="gray-bg">

    <nav class="container-fluid app-nav">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a href="{{ url('/dashboard') }}">
                        <img src="{{ asset('public/insightapp') }}/images/insight-logo.svg" width="146" height="40" alt="Insight - Share Your Knowledge" title="Insight Logo">
                    </a>
                </div>
                <div class="col-6 text-center">
                @guest
                @else
                    <a href="{{ url('/dashboard') }}" class="app-menu-item dashboard-active d-none d-lg-inline-block d-md-inline-block ">Expert</a>
                    <a href="{{ url('/my-questions') }}" class="app-menu-item my-questions-active d-none d-lg-inline-block d-md-inline-block">My Questions</a>
                @endguest 
                </div>

                @guest
                @else
                <div class="col-3 text-right">
                    <div class="dropdown d-none d-lg-inline-block d-md-inline-block">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        @if(Auth::user()->profile_photo)
                        <div class="menu-account-photo" style="background-image: url('{{ asset('public/uploads/user_profiles/'.Auth::user()->profile_photo ) }}')"></div>
                        @else
                            <div class="menu-account-photo" style="background-image: url('{{ asset('public/insightapp/images/profile-photo.jpg') }}')"></div>
                        @endif
                            <p class="app-menu-item">{{ Auth::user()->first_name}} {{ Auth::user()->last_name }}</p>
                        </a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item text-right" href="{{ url('/') }}/{{ Auth::user()->name }}"> {{ __('View Profile') }} </a>
                            <a class="dropdown-item text-right" href="{{ url('/transactions') }}"> {{ __('Transactions') }} </a>
                            <a class="dropdown-item text-right" href="{{ url('/settings') }}">{{ __('Settings') }}</a>
                            <a class="dropdown-item text-right logout-link" href="{{ route('logout') }}" onclick="event.preventDefault();
											 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest   
                    <!-- Mobile Menu -->
                    <button class="navbar-toggler d-inline-block d-sm-inline-block d-md-none d-lg-none text-right" type="button" data-toggle="collapse" data-target="#appMobileNav" aria-controls="appMobileNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse dropdown-menu" id="appMobileNav">
                        <a class="dropdown-item text-right" href="{{ url('/dashboard') }}">Expert</a>
                        <a class="dropdown-item text-right" href="{{ url('/my-questions') }}">My Questions</a>
                        
                        @guest
                        <a class="dropdown-item text-right" href="{{ url('/login') }}">Log In</a>
                        @if (Route::has('register'))
                        <a class="dropdown-item text-right" href="{{ url('/register') }}">Create an Account</a> 
                        @endif
                        @else    
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-right" href="{{ url('/') }}/{{ Auth::user()->name }}">View Profile</a>
                            <a class="dropdown-item text-right" href="{{ url('/transactions') }}">Transactions</a>
                            <a class="dropdown-item text-right" href="{{ url('/settings') }}">Settings</a>
                            <a class="dropdown-item text-right logout-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        @endguest  
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div id="app">

        @yield('content')

    </div>

    




    





    <!-- FontAwesome 4 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!--
<link rel="stylesheet" href="{{ asset('public/insightapp/css/fontawesome/all.css') }}">
-->

    <!-- Animate.css -->
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"-->
    <link rel="stylesheet" href="{{ asset('public/insightapp/css/animate/animate.min.css') }}">


    <!-- jQuery and Bootstrap -->
    <!--
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
-->

    <script src="{{ asset('public/insightapp/js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('public/insightapp/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/insightapp/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/insightapp/js/bootstrap.min.js') }}"></script>


    <script>
        $(document).ready(function() {

            /* Show and Hide Password Field */
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye");
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye");
                    $('#show_hide_password i').addClass("fa-eye-slash");
                }
            });

        });

        /* Enable Tooltips */
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    <!-- Include page js script here -->
    @yield('pagejs')

</body>

</html>