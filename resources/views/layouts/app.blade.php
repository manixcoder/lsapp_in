<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon content -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/insightapp') }}/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/insightapp') }}/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/insightapp') }}/images/favicon-16x16.png">
    <!-- <link rel="manifest" href="{{ asset('public') }}/site.webmanifest"> -->
    <link rel="mask-icon" href="{{ asset('public/insightapp') }}/images/safari-pinned-tab.svg" color="#0078d7">
    <meta name="msapplication-TileColor" content="#0078d7">
    <meta name="theme-color" content="#0078d7">



    <!-- Scripts -->
    <!--script src="{{ asset('public/js/app.js') }}" defer></script--->

    <!-- Bootstrap 4.3.1 -->
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"-->
    <link rel="stylesheet" href="{{ asset('public/insightapp/css/bootstrap/bootstrap-4.3.1.min.css') }}">

    <!-- Main stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/insightapp/css/style.css') }}">


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-134698258-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-134698258-1');
    </script>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Insight is a communication tool that connects you to people who have a problem to solve. Lend your expertise and empower people to do great things.">
    <link rel="canonical" href="https://www.insightapp.co/">
    <!-- include Page CSS -->
    @yield('pageCss')


</head>

<body>

    <nav class="container navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('public/insightapp') }}/images/insight-logo.svg" width="146" height="40" alt="Insight - Share Your Knowledge" title="Insight Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#frontend-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="frontend-nav">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Log In</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Create an Account</a> 
                    </li>
                    @endif
                @else
               
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
                            <!-- <a class="dropdown-item text-right" href="{{ url('/profile') }}/">View Profile</a> -->
                            <a class="dropdown-item text-right" href="{{ url('/') }}/{{ Auth::user()->name }}">View Profile</a>
                            
                            <a class="dropdown-item text-right" href="{{ url('/transactions') }}">Transactions</a>
                            <a class="dropdown-item text-right" href="{{ url('/settings') }}/">Settings</a>
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
            </ul>
        </div>
    </nav>
    <div id="app">

        @yield('content')

    </div>

    <footer class="container-fluid dark-bg padding-40-15">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <a href="/"><img src="{{ asset('public/insightapp') }}/images/insight-white-logo.svg" alt="Insight App" title="Insight" class="footer-logo"></a>
                </div>
                <div class="col-md-6 col-sm-12">
                    <p class="text-white text-center footer-text">© <script>
                            document.write(new Date().getFullYear());
                        </script> Insight. Made with ♥️ in Nashville.<br>
                        <a href="/privacy" class="footer-link">Privacy</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="/terms" class="footer-link">Terms</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" class="footer-link" data-toggle="modal" data-target="#media">Media</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" class="footer-link" data-toggle="modal" data-target="#contact">Contact</a>
                    </p>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="center-sm">
                        <a href="https://facebook.com/pg/Insight-370969843494917" target="_blank" class="footer-social"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://twitter.com/insightappco" target="_blank" class="footer-social"><i class="fab fa-twitter-square"></i></a>
                        <a href="https://www.linkedin.com/company/insightappco" target="_blank" class="footer-social"><i class="fab fa-linkedin"></i></a>
                        <a href="https://instagram.com/insightappco" target="_blank" class="footer-social"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contact-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="contact-label">Contact Us</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>If you have questions or need help with Insight, please email us at <a href="mailto:hello@insightapp.co">hello@insightapp.co</a>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Dismiss</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Modal -->
    <div class="modal fade" id="media" tabindex="-1" role="dialog" aria-labelledby="media-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="media-label">Media Inquiries</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Coming Soon.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Dismiss</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cookie Policy -->
    <div id="cookieAcceptBar" class="cookieAcceptBar animated fadeInUp" style="display: none;">
        <div class="font-22">🍪</div> &nbsp;By browsing this website, you consent to our <a href="/privacy">privacy policy</a> — <button id="cookieAcceptBarConfirm">I agree</button>
    </div>

    <!-- FontAwesome 4 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!--
<link rel="stylesheet" href="{{ asset('public/insightapp/css/fontawesome/all.css') }}">
-->

    <!-- Animate.css -->
    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"-->
    <link rel="stylesheet" href="{{ asset('public/insightapp/css/animate/animate.min.css') }}">


    <!-- Call JS File Here ---->
    <!--
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
-->

    <script src="{{ asset('public/insightapp/js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('public/insightapp/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/insightapp/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/insightapp/js/jquery.cookie.js') }}"></script>


    <script>
        $(document).ready(function() {
            if (window.location.href.indexOf('#media') != -1) {
                $('#media').modal('show');
            }

            if (window.location.href.indexOf('#contact') != -1) {
                $('#contact').modal('show');
            }
            cookiesPolicyBar();
        });

        function cookiesPolicyBar() {
            if ($.cookie('cookieAccept') == null) {
                $('#cookieAcceptBar').show();
            } else {
                $('#cookieAcceptBar').hide();
            }
            $('#cookieAcceptBarConfirm').on('click', function() {
                $.cookie('cookieAccept', 'active', {
                    expires: 90
                });
                $('#cookieAcceptBar').hide();
            });
        }
    </script>

    <!-- Email Subscription success Modal -->
    <div class="modal fade" id="subscription-success" tabindex="-1" role="dialog" aria-labelledby="subscription-success-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="subscription-success-label">Subscription Successful</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body font-18">
                    <p><span class="dark-bold">Thank you!</span> You have successfully subscribed to our list.</p>
                    <p>If you want to get the most of what we have to offer, follow us on social media. We'll post valuable content that you won't necessarily get through email.</p>
                    <p class="padding-bottom-0 margin-bottom-0"><span class="dark-bold">Where to follow us:</span></p>
                    <div class="email-social-links">
                        <a href="https://facebook.com/pg/Insight-370969843494917" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://twitter.com/insightappco" target="_blank"><i class="fab fa-twitter-square"></i></a>
                        <a href="https://www.linkedin.com/company/insightappco" target="_blank"><i class="fab fa-linkedin"></i></a>
                        <a href="https://instagram.com/insightappco" target="_blank"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            if (window.location.href.indexOf('#subscription-success') != -1) {
                $('#subscription-success').modal('show');
            }
        });
    </script>

    <!-- Include page js script here -->
    @yield('pagejs')

</body>

</html>