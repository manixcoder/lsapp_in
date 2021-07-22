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

	<title>@yield('pageTitle')</title>

	<meta name="description" content="Insight is a communication tool that connects you to people who have a problem to solve. Lend your expertise and empower people to do great things.">
	<link rel="canonical" href="https://www.insightapp.co/">
	<!-- include Page CSS -->
	@yield('pageCss')

</head>

<body class="gray-bg app">

	<div class="container max-width-400">
		<a class="account-logo" href="{{ url('/') }}">
			<img src="{{ asset('public/insightapp') }}/images/insight-logo.svg" width="146" height="40" alt="Insight - Share Your Knowledge" title="Insight Logo">
		</a>
	</div>

	<div id="app">
		@yield('content')
	</div>


	<!-- FontAwesome 5 -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<!-- Animate.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

	<!-- jQuery and Bootstrap -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


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