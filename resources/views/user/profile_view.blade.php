@extends('layouts.inner')
@section('pageTitle', 'Public Profile')
@section('pageCss')
@stop
@section('content')
@php
   //dd(env('STRIPE_SECRET'));
@endphp
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
<div class="container sheet profile-sheet">
	<div class="d-flex">
		@if($user_data['profile_photo'])
		<div style="background-image:url('{{ asset('public/uploads/user_profiles/'.$user_data['profile_photo'] ) }}')" class="profile-photo"></div>
		@else
		<div style="background-image:url('{{ asset('public/insightapp/images/profile-photo.jpg') }}')" class="profile-photo"></div>
		@endif

		<div class="flex-grow-1">
			<p class="profile-name">{{ $user_data['first_name']}} {{ $user_data['last_name'] }}</p>
			<p class="profile-stat-star">
				@php $ratingData = $ratingValue; @endphp
				@if($ratingData > 0)
					@foreach(range(1,5) as $i)
					   @if($ratingValue > 0)
				@if($ratingValue > 0.5)
				<span class="fa fa-star checked"></span>
				@else
				<span class="fa fa-star-half-o checked"></span>
				@endif
				@else
				<span class="fa fa-star-o"></span>
				@endif
				@php $ratingValue--; @endphp
				@endforeach
				<a href="" data-toggle="modal" data-target="#reviews">{{ count($ratingReview) }} Reviews</a>
				@else
				<i class="far fa-star"></i>
				<i class="far fa-star"></i>
				<i class="far fa-star"></i>
				<i class="far fa-star"></i>
				<i class="far fa-star"></i>
				@endif
				<!-- <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>  -->
				
				<!-- <a href="" data-toggle="modal" data-target="#reviews">{{ $totalReview }} Reviews</a> -->
			</p>
		</div>
	</div>
	<p class="profile-bio">
		{{ $user_data['profile_bio'] }}
	</p>
	<p class="profile-website"><a href="{{ $user_data['website_url'] }}" target="_blank">{{ $user_data['website_url'] }}</a></p>
	<hr>
	<?php if($user_data['is_accept_new_questions']=='No'){
		echo $user_data['first_name']." is not accepting new questions right now.";
	}else{?>
		
	<h1 class="profile-header">Ask {{ $user_data['first_name'] }} Your Question</h1>
	@guest
	<p class="profile-not-logged-in">
		<i class="fas fa-info-circle blue-text"></i> Please <a href="{{ url('/login') }}">log in</a> or <a href="{{ url('/register') }}">create an account</a> to ask a question.</p>
	@else
	<!-- <p class="login-status text-center">You are logged in</p> -->
	@endguest
	<form action="{{ url('/ask_question') }}" method="POST" id="questionForm">
		@csrf
		@guest
		@else
		<input type="hidden" name="seeker_id" value="{{ Auth::user()->id }}">
		<input type="hidden" name="expert_id" value="{{$user_data['id']}} ">
		@endguest
		<textarea required name="question_text" class="form-control" rows="6"></textarea>
		<div class="form-group form-check profile-email-optin">
			<input type="checkbox" class="form-check-input" name="email_optin" value="1" id="email-optin">
			<label class="form-check-label font-14" for="remail-optin">I would like to receive emails from {{ $user_data['first_name']}} {{ $user_data['last_name'] }}</label>
		</div>
		<hr>
		<?php //dd($user_data['payment_options']);
		?>
		@if($user_data['payment_options'] =='price_Range')
		<p>How much is this answer worth to you?</p>
		<div class="d-flex">
			<label class="btn btn-white mr-2 btn_amo" for="Amount_5">${{ $user_data['lower_price'] }}
				<input type="radio" style="visibility: hidden; " id="Amount_5" class="btn btn-white mr-2 btn_amount" name="question_worth" value="<?php echo $user_data['lower_price']?>" />
			
			</label>
			<label class="btn btn-white mr-2 btn_amo" for="Amount_10">${{ $user_data['medium_price'] }}
				<input type="radio" style="visibility: hidden; " id="Amount_10" class="btn btn-white mr-2 btn_amount" name="question_worth" value="{{ $user_data['medium_price'] }}" />
			</label>
			<label class="btn btn-white mr-2 btn_amo" for="Amount_20">${{ $user_data['higher_price'] }}
				<input type="radio" style="visibility: hidden; " id="Amount_20" class="btn btn-white mr-2 btn_amount" name="question_worth" value="{{ $user_data['higher_price'] }}" />
			</label>


			<input type="text" class="form-control mr-2" id="otherAmount" name="otherAmount" aria-describedby="otherAmount"  placeholder="Other Amount">

			
			<span id="errmsg" style="color: red;"></span>
			@guest
			 <button type="button" class="btn btn-primary" disabled data-toggle="modal" id="creditcardHide" data-target="#creditcard">Ask</button>
			@else
				@if(Auth::user()->id != $user_data['id'])
					@if($stripe_token == '' )
						<button type="button" class="btn btn-primary" id="creditcardHide"  data-toggle="modal" data-target="#creditcard">Ask</button>
						@else
						<button type="submit" id="creditcardHide" class="btn btn-primary">Ask</button>
						@endif
				@else
					<button type="submit" disabled id="creditcardHide" class="btn btn-primary">Ask</button>
				@endif
				@endguest
			
			

		</div>

		<div class="amount_error">
			@if ($errors->has('otherAmount'))
			<span class="invalid-alert" role="alert">
				<strong>{{ $errors->first('otherAmount') }}</strong>
			</span>
			@endif
		</div>

		@elseif($user_data['payment_options'] =='single_price')
		<div class="d-flex">
			
			<span> Get an answer from {{$user_data['first_name']}} for ${{$user_data['single_price']}}.00</span>
			<input type="hidden" class="form-control mr-2" id="otherAmount" name="otherAmount" aria-describedby="otherAmount"  placeholder="Other Amount" value="{{ $user_data['single_price'] }}">
			<span id="errmsg" style="color: red;"></span>
			@guest
			 <button type="button" class="btn btn-primary" disabled data-toggle="modal" id="creditcardHide" data-target="#creditcard">Ask</button>
			@else
			
				@if(Auth::user()->id != $user_data['id'])
					@if($stripe_token == '')
						<button type="button" class="btn btn-primary" id="creditcardHide"  data-toggle="modal" data-target="#creditcard">Ask</button>
						@else
						<button type="submit" id="creditcardHide" class="btn btn-primary">Ask</button>
						@endif
				@else
					<button type="submit" disabled id="creditcardHide" class="btn btn-primary">Ask</button>
				@endif
				@endguest
			</div>

		@elseif($user_data['payment_options'] =='free')
		<div class="d-flex">
			<!-- <span> Get an answer from Manish for free</span> -->
			<input type="hidden" class="form-control mr-2" id="otherAmount" name="otherAmount" aria-describedby="otherAmount"  placeholder="Other Amount" value="0">
			<span id="errmsg" style="color: red;"></span>
			@guest
			 <button type="button" class="btn btn-primary" disabled data-toggle="modal" id="creditcardHide" data-target="#creditcard">Ask</button>
			@else
			
				@if(Auth::user()->id != $user_data['id'])
					<button type="submit" id="creditcardHide" class="btn btn-primary">Ask</button>
				@else
					<button type="submit" disabled id="creditcardHide" class="btn btn-primary">Ask</button>
				@endif
				@endguest
			</div>
		@endif
		
		<p class="font-12 pt-4">If {{ $user_data['first_name'] }} declines or does not answer your question in 7 days, you will not be charged.</p>
	</form>
	<?php }?>
</div>
<script type="text/javascript">
	$(document).ready(function () {
  //called when key is pressed in textbox
  $("#otherAmount").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
</script>
<!-- CREDIT CARD Modal -->
<div class="modal fade" id="creditcard" tabindex="-1" role="dialog" aria-labelledby="creditcardModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header_1 app-modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fas fa-times"></i></span>
				</button>
				<div class="user-photo creditIcone">
					<img src="{{ asset('public/insightapp') }}/images/apple-touch-icon.png" alt="Girl in a jacket">
				</div>
				<h4 class="modal-title app-modal-title" id="reviewsModal">Insight Checkout</h4>

				<h6 class="modal-title app-modal-title" id="reviewsModal">Collect card information</h6>
				@guest
				<input type="text" name="user_email" value="" class="credit_email" disabled>
				@else
				<input type="text" name="user_email" value="{{ Auth::user()->email }}" class="credit_email" disabled>
				@endguest


			</div>
			<div class="modal-body card_box">
				<!-- CREDIT CARD -->
				<div class="single-review d-flex">
					<div class="flex-grow-1">
						<div class="row">

							<form  action="{{ url('/charge') }}" method="post" id="payment-form">
								@csrf
								<div class="form-row">
									<div class="form-group form-check carddetails" id="card-element">

									</div>

									<div class="form-group form-check carddetails_error" id="card-errors" role="alert"></div>
									<div id="remaimber" class="form-group form-check profile-email-optin">
										<input type="checkbox" name="remaimber">
										<label for="remaimember">Remember Me</label>
									</div>
								</div>
								<button  class="checkout_btn btn btn-primary">Save</button>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@if($ratingReview)
<!-- REVIEWS Modal -->
<div class="modal fade" id="reviews" tabindex="-1" role="dialog" aria-labelledby="reviewsModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header app-modal-header">
				<h4 class="modal-title app-modal-title" id="reviewsModal">Reviews</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="fas fa-times"></i></span>
				</button>
			</div>
			<div class="modal-body">

				<!-- REVIEW -->
				@foreach($ratingReview as $review)
				<div class="single-review d-flex">
					@if($review['seekerData']['profile_photo'])
					<div style="background-image:url('{{ asset('public/uploads/user_profiles/'.$review['seekerData']['profile_photo'] ) }}')" class="user-photo"></div>
					@else
					<div style="background-image:url('http://localhost/insight_app/public/insightapp/images/profile-photo.jpg')" class="user-photo"></div>
					@endif
					<div class="flex-grow-1">
						<div class="row">
							<div class="col">
								<div class="reviewer-name">{{ $review['seekerData']['first_name']}} {{ $review['seekerData']['last_name']}}</div>
							</div>
							<div class="col">
								<div class="text-right review-date">
									<?php
									$timestamp = strtotime($review['created_at']);
									$new_date_format = date('d F, Y ', $timestamp);
									//$date = ($timestamp)->format('M d, Y H:ia');
									//April 16, 2019
									?>
									{{ $new_date_format }}
								</div>
							</div>
						</div>
						<p class="review-star">
							@php $ratingData = $review['rating']; @endphp
							@foreach(range(1,5) as $i)
							@if($ratingData > 0)
							@if($ratingData > 0.5)
							<i class="fa fa-star checked"></i>
							@else
							<i class="fa fa-star-half-o checked"></i>
							@endif
							@else
							<i class="fa fa-star-o"></i>
							@endif
							@php $ratingData--; @endphp
							@endforeach
							<!-- <i class="fas fa-star"></i> -->
							<!-- <i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star-half-alt"></i> -->
						</p>
						<div class="reviewer-feedback">
							<em>
								<?php if ($review['feed_back'] != '') {
									echo $review['feed_back'];
								} else {
									echo "No feedback";
								}
								?>
							</em>
						</div>
					</div>
				</div>
				@endforeach

				<!-- REVIEW -->
				<!-- <div class="single-review d-flex">
						<div style="background-image:url('https://static8.depositphotos.com/1167812/876/i/950/depositphotos_8760055-stock-photo-headshot-of-a-young-man.jpg')" class="user-photo"></div>
						<div class="flex-grow-1">
							<div class="row">
								<div class="col">
									<div class="reviewer-name">Sam Johnson</div>
								</div>
								<div class="col">
									<div class="text-right review-date">April 9, 2019</div>
								</div>
							</div>
							<p class="review-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></p>
							<div class="reviewer-feedback">Lorem ipsum dolor sit amet elicit son tempour. Etiam pretium, eros sed venenatis fringilla. Etiam pretium, eros sed venenatis fringilla, nisi risus lorem ipsum dolor.</div>
						</div>
					</div> -->

			</div>
		</div>
	</div>
</div>
@else
<div class="modal fade" id="reviews" tabindex="-1" role="dialog" aria-labelledby="reviewsModal" aria-hidden="true">
	<div class="modal-content">
		<div class="modal-header app-modal-header">
			<h4 class="modal-title app-modal-title" id="reviewsModal">Reviews</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true"><i class="fas fa-times"></i></span>
			</button>
		</div>
		<div class="modal-body">
			<div class="single-review d-flex">
				No Review
			</div>

		</div>
	</div>
</div>
@endif
<script type="text/javascript">
	$(document).ready(function() {
		$(".btn_amount").click(function() {
			$("input[name=otherAmount]").val('');
		});

		$("input[name=otherAmount]").click(function() {
			$(".btn_amo").removeClass("active");
			$(".btn_amount").prop("checked", false);
		});
		$(".btn_amo").click(function() {
			$(".btn_amo").removeClass("active");
			$(this).addClass("active");
		});
	});
	//var name = '{{ env('STRIPE_KEY') }}';
	//alert(name);
	// Create a Stripe client.
	var stripe = Stripe('{{ env("STRIPE_KEY") }}');
	// Create an instance of Elements.
	var elements = stripe.elements(
		hidePostalCode = true
	);
	// Custom styling can be passed to options when creating an Element.
	// (Note that this demo uses a wider set of styles than the guide below.)
	var style = {
		base: {
			color: '#32325d',
			fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
			fontSmoothing: 'antialiased',
			fontSize: '16px',
			'::placeholder': {
				color: '#aab7c4'
			}
		},
		invalid: {
			color: '#fa755a',
			iconColor: '#fa755a'
		}
	};
	// Create an instance of the card Element.
	var card = elements.create('card', {
		style: style
	});
	// Add an instance of the card Element into the `card-element` <div>.
	card.mount('#card-element');
	// Handle real-time validation errors from the card Element.
	card.addEventListener('change', function(event) {
		var displayError = document.getElementById('card-errors');
		if (event.error) {
			displayError.textContent = event.error.message;
		} else {
			displayError.textContent = '';
		}
	});
	// Handle form submission.
	var form = document.getElementById('payment-form');
	form.addEventListener('submit', function(event) {
		event.preventDefault();

		stripe.createToken(card).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error.
				var errorElement = document.getElementById('card-errors');
				errorElement.textContent = result.error.message;
			} else {
				// Send the token to your server.
				stripeTokenHandler(result.token);
			}
		});
	});	
	// Submit the form with the token ID.
	function stripeTokenHandler(token) {
		$.ajax({
			'url': "{{ url('/charge') }}",
			'method': 'post',
			'dataType': 'json',
			//'data': $("#payment-form").serialize(),
			'data': {_token: '{{csrf_token() }}' ,stripeToken:token.id},
			success: function(data) {
				if (data.status == 'success') {
					$("#creditcard").modal('toggle');
					$("#creditcardHide").css("display", "none");
					$("input[name=otherAmount]").after('<button type="submit" class="btn btn-primary">Ask</button>');
				}
			}
		});
		// Insert the token ID into the form so it gets submitted to the server
		var form = document.getElementById('payment-form');
		var hiddenInput = document.createElement('input');
		hiddenInput.setAttribute('type', 'hidden');
		hiddenInput.setAttribute('name', 'stripeToken');
		hiddenInput.setAttribute('id', 'stripeToken');
		hiddenInput.setAttribute('value', token.id);
		form.appendChild(hiddenInput);
		// Submit the form
		// form.submit();
	}
	
</script>

<style>
	/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
	.StripeElement {
		box-sizing: border-box;
		height: 40px;
		padding: 10px 12px;
		border: 1px solid transparent;
		border-radius: 4px;
		background-color: white;
		box-shadow: 0 1px 3px 0 #e6ebf1;
		-webkit-transition: box-shadow 150ms ease;
		transition: box-shadow 150ms ease;
		width: 60%;
	}
	.StripeElement--focus {
		box-shadow: 0 1px 3px 0 #cfd7df;
	}
	.StripeElement--invalid {
		border-color: #fa755a;
	}
	.StripeElement--webkit-autofill {
		background-color: #fefde5 !important;
	}
	#payment-form {
		width: 100%;
	}
	#creditcard .modal-dialog {
		max-width: 350px;
		text-align: center;
	}
	.app-modal-header {
		border-bottom: 1px solid #D2D4D6;
		background: #eee;
		border-radius: 0px;
		box-shadow: none !important;
	}
	.modal-header_1 button.close {
		background: #0062cc;
		opacity: 1;
		color: #fff;
		font-size: 13px;
		font-weight: normal;
		padding: 6px 8px;
		border-radius: 50px;
		position: relative;
		top: -7px;
		left: 6px;
	}
	.user-photo.creditIcone {
		margin-right: 0px;
		width: 100%;
		border: 0px;
		position: relative;
		float: left;
		margin-top: -67px;
		margin-bottom: 42px;
	}
	.user-photo.creditIcone img {
		width: 50px;
		border-radius: 50px;
		display: inline-block;
		text-align: center;
	}
	h4#reviewsModal {
		float: left;
		width: 100%;
		font-size: 14px;
		font-weight: bold;
		letter-spacing: 1px;
	}
	h6#reviewsModal {
		font-weight: 500;
		font-size: 15px;
		width: 100%;
		text-align: center;
		line-height: 27px;
		display: inline-block;
		float: left;
		margin-bottom: 12px;
	}
	div#card-element {
		float: left;
		width: 100%;
		border: 1px solid #e9e9e9;
		margin-bottom: 0;
	}
	.modal-body .row {
		display: inline-block;
		width: 85%;
		margin: 0 auto;
	}
	div#remaimber {
		float: left;
		width: 100%;
		padding-left: 0px;
		padding: 7px 0px !important;
		margin-top: 0px;
		font-size: 13px;
		margin-bottom: 0px;
		border: 1px solid #eee;
		border-radius: 4px;
		font-weight: 600;
		letter-spacing: 0.5px;
	}
	div#remaimber label {
		margin-bottom: 0px;
	}
	#remaimber input {
		position: relative;
		top: 3px;
		right: 4px;
	}
	.checkout_btn {
		border-radius: 5px;
		border: 0px;
		width: 100%;
		margin-top: 15px;
		padding: 11px 0px;
		font-weight: bold;
		text-transform: capitalize;
		letter-spacing: 1px;
		font-size: 16px;
	}
	.card_box {
		padding: 35px 0px;
	}
	.card_box .single-review.d-flex {
		border-bottom: 0px;
	}
	.credit_email {
		background: transparent;
		border: 0px;
		text-align: center;
		font-size: 13px;
		float: left;
		width: 100%;
		padding-left: 0px;
		font-weight: bold;
		letter-spacing: 0.5px;
		padding-bottom: 16px;
	}
	.amount_error{
		float: left;
		width: 100%;
	}
</style>
@endsection
@section('pagejs')
@stop