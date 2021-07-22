@extends('layouts.app')
@section('content')

<section class="container">
	@if(Session::get('status') == "success")
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-check"></i>{{ Session::get('message') }}
    </div>
    @elseif(Session::get('status') == "danger")
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-ban"></i>{{ Session::get('message') }}
    </div>
    @endif
	<div class="row">
		<div class="col-xl-6 col-lg-7 order-xl-1 order-lg-1 order-md-2 order-sm-2 order-2">
			<div class="hero-message">
				<h1>Share Your Knowledge</h1>
				<h2>Make connections, solve problems, and empower people to do great things.</h2>


				<a href="{{ route('register') }}" class="btn btn-primary btn-lg">Create a Free Account</a>

			</div>
		</div>

		<div class="col-xl-6 col-lg-5 order-xl-2 order-lg-2 order-md-1 order-sm-1 order-1">
			<img class="hero-image img-fluid animated fadeIn" src="{{ asset('public/insightapp') }}/images/hero.svg" alt="Make money answering questions with Insight" title="Share Your Knowledge with Insight">
		</div>
	</div>
</section>

<section class="container">
	<hr class="horizontal-rule">
</section>

<section class="container padding-60-15">
	<h2 class="text-center">What Is Insight</h2>
	<p class="subhead text-center max-width-680">Insight allows you to communicate with people on an online profile and help them solve problems by answering questions.</p>
	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-12 animated fadeInUp faster delay-4">
			<img class="what-icon" src="{{ asset('public/insightapp') }}/images/solve-problems.svg" alt="Solve Problems" title="Answer questions and solve problems">
			<h3 class="what-header">Solve Problems</h3>
			<p>Enable people to find solutions to real problems and make the world a better place.<br><br></p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 animated fadeInUp faster delay-5">
			<img class="what-icon" src="{{ asset('public/insightapp') }}/images/gain-an-audience.svg" alt="Gain an Audience" title="Gather an audience on Insight">
			<h3 class="what-header">Gain an Audience</h3>
			<p>Collect email addresses of people interested in your message.<br><br></p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 animated fadeInUp faster delay-2">
			<img class="what-icon" src="{{ asset('public/insightapp') }}/images/earn-money.svg" alt="Earn Money" title="make money answering questions">
			<h3 class="what-header">Earn Money</h3>
			<p>You’ve worked hard to learn what you know. Make money giving thoughtful answers.<br><br></p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 animated fadeInUp faster delay-1">
			<img class="what-icon" src="{{ asset('public/insightapp') }}/images/empower-people.svg" alt="Empower People" title="Empower people to do great things">
			<h3 class="what-header">Empower People</h3>
			<p>Your knowledge can enable people to thrive and be successful.<br><br></p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 animated fadeInUp faster delay-3">
			<img class="what-icon" src="{{ asset('public/insightapp') }}/images/fuel-your-passion.svg" alt="Fuel Your Passion" title="Do what you love">
			<h3 class="what-header">Fuel Your Passion</h3>
			<p>Lend a helping hand to enthusiasts who share the same interests as you.<br><br></p>
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12 animated fadeInUp faster delay-6">
			<img class="what-icon" src="{{ asset('public/insightapp') }}/images/build-a-reputation.svg" alt="Build a Reputation" title="Build rapport with people by lending your knowledge">
			<h3 class="what-header">Build a Reputation</h3>
			<p>Become the go-to resource in your industry and earn valuable ratings.<br><br></p>
		</div>
	</div>
</section>

<section class="container-fluid blue-bg padding-60-15">
	<h3 class="text-center text-white mb-4">Start answering questions today.</h3>
	<center>
		<a href="{{ route('register') }}" class="btn btn-primary-white btn-lg">Create a Free Account</a>
	</center>
</section>

<section class="container padding-60-15">
	<h2 class="text-center">What Is Insight</h2>
	<div class="row max-width-860" style="margin-top:20px;">
		<div class="col-md-4 col-sm-12">
			<img class="how-icon" src="{{ asset('public/insightapp') }}/images/one.svg" alt="Step 1" title="Step 1">
			<h3 class="what-header text-center">Receive Questions</h3>
			<p class="text-center">Get questions through your online profile.<br><br></p>
		</div>
		<div class="col-md-4 col-sm-12">
			<img class="how-icon" src="{{ asset('public/insightapp') }}/images/two.svg" alt="Step 2" title="Step 2">
			<h3 class="what-header text-center">Get Feedback</h3>
			<p class="text-center">Receive feedback on your answer and build a reputation.<br><br></p>
		</div>
		<div class="col-md-4 col-sm-12">
			<img class="how-icon" src="{{ asset('public/insightapp') }}/images/three.svg" alt="Step 3" title="Step 3">
			<h3 class="what-header text-center">Give Thoughtful Answers</h3>
			<p class="text-center">Review questions and respond with your answer.<br><br></p>
		</div>
	</div>
</section>

<section class="container-fluid gray-bg padding-60-15">
	<h3 class="text-center">Don't Miss Anything</h3>
	<p class="text-center">Subscribe to our newsletter to get updates.</p>
	<!-- Begin Mailchimp Signup Form -->
	<center>
		<div id="mc_embed_signup">
			<form action="https://insightapp.us20.list-manage.com/subscribe/post?u=70747ea48ac8c65004cc378b1&amp;id=d7e69e306d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div id="mc_embed_signup_scroll">
					<div class="mc-field-group">
						&nbsp;&nbsp;<input type="email" value="" name="EMAIL" class="form-control email-input-hero required email" id="mce-EMAIL" placeholder="Email Address">
						<input type="submit" value="Notify Me" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-primary btn-email">
					</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_70747ea48ac8c65004cc378b1_d7e69e306d" tabindex="-1" value=""></div>

				</div>
			</form>
		</div>
	</center>
	<!--End mc_embed_signup-->
</section>
@endsection