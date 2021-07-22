@extends('layouts.inner')
@section('pageTitle', 'Dashboard')

@section('pageCss')
<style>
	.dashboard-active {
		font-weight: 700;
		color: #0074DB;
		border-bottom: 1px solid #0074DB;
	}

	.showMessages {
		text-decoration: none;
		color: inherit;
	}

	.showMessages:hover {
		text-decoration: none;
		color: inherit;
	}
</style>
@stop

@section('content')
<?php
$total = "0";
foreach ($question_data as $qData) {
	$total += $qData->question_worth;
}
?>

<div class="container dash-stats">
	<div class="row">
		<div class="col-6 col-sm-4 col-md-4 col-lg">
			<p class="dash-stat-header">Visitors</p>
			<p class="dash-stat">{{ $visitorNum }}</p>
			<p class="dash-stat-subhead">Past 30 days</p>
		</div>
		<div class="col-6 col-sm-4 col-md-4 col-lg">
			<p class="dash-stat-header">Questions</p>
			<p class="dash-stat">{{ count($question30Day) }}</p>
			<p class="dash-stat-subhead">Past 30 days</p>
		</div>
		<div class="col-6 col-sm-4 col-md-4 col-lg">
			<p class="dash-stat-header">Response Time</p>
			<!-- <p class="dash-stat">4.5</p> -->
			<p class="dash-stat">{{ round($averageTime/60/60, 2)  }}</p>
			<p class="dash-stat-subhead">Average (Hours)</p>
		</div>
		<div class="col-6 col-sm-4 col-md-4 col-lg">
			<p class="dash-stat-header">Available Balance</p>
			<p class="dash-stat">${{ $total }}.00</p>
			<!-- <p class="dash-stat">$287.00</p> -->
			@if(Auth::user()->stripe_user_id =='')
			<p class="dash-stat-subhead"><a href="{{ url('/dashboard/stripeAccountCreate') }}">Create Stripe Payout</a></p>
			@else
			<p class="dash-stat-subhead"><a href="{{ url('/transactions') }}">Request Payout</a></p>
			@endif


		</div>
		<div class="col-6 col-sm-4 col-md-4 col-lg">
			<p class="dash-stat-header">Ratings</p>
			@php $ratingData = $ratingValue; @endphp

			@if($ratingData == 0)
			<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
			<br> No Review
			@else
			<p class="dash-stat-star">
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
					  @php 
					  		$ratingValue--; 
					  @endphp
				@endforeach
			</p>
			<p class="dash-stat-subhead">{{ $ratingData }} Stars | <a href="" data-toggle="modal" data-target="#reviews">{{ $totalReview }} Reviews</a></p>
			@endif
			
		</div>
	</div>
</div>
<!-- TEMP -->
<div class="container">
	@guest
	<p class="login-status text-center">You are logged out</p>
	@else
	<p class="login-status text-center">You are logged in</p>
	@endguest
</div>

<div class="container sheet dash-questions-container p-0">
	<div class="row">
		<div class="col-4 thread-list">
			<div class="toolbar d-flex pr-1">
				<input class="form-control form-control-sm toolbar-search-input" type="text" placeholder="Search">
				<button type="button" class="btn btn-sm toolbar-btn" data-toggle="modal" data-target="#download-emails"><i class="fas fa-cloud-download-alt"></i></button>
				<button type="button" class="btn btn-sm toolbar-btn" data-toggle="modal" data-target="#form-embed"><i class="fas fa-code"></i></button>
			</div>
			<div class="threads">
				
				@if(count($conversations) > 0)
				@foreach($conversations as $c)
				<div class="thread-list-item">
					<a href="#" data-id="{{ $c['id'] }}" class="showMessages">
						<div class="row">
							<div class="col">
								<div class="thread-name">{{ $c['questionData']['seekersData']['first_name']}} {{ $c['questionData']['seekersData']['last_name']}}</div>
							</div>
							<div class="col">
								@php
								$date = ($c['questionData']['created_at'])->format('M d, Y H:ia');
								@endphp
								<div class="thread-date">{{ $date }} </div>
							</div>
						</div>
						<div class="thread-message">{{ $c['questionData']['question_text']}}</div>
						<div class="thread-info">
							<span class="thread-status">
								@if ($c['questionData']['is_active'] == '1')
								<span class="que_open">OPEN QUESTION</span>
								@elseif ($c['questionData']['is_active'] == '2')
								<span class="que_open">OPEN QUESTION</span>
								<!-- <div class="que_accept">ACCEPTED</div> -->
								@elseif ($c['questionData']['is_active'] == '3')
								<span class="que_decline"><i class="fa fa-times"></i> DECLINED </span>
								@elseif ($c['questionData']['is_active'] == '4')
								<span class="que_expire"><i class="fa fa-times"></i> EXPIRED</span>
								@elseif ($c['questionData']['is_active'] == '5')
								<span class="que_complete"><i class="fa fa-check"></i> COMPLETED</span>
								@endif
							</span>
							<span class="thread-offer"> &nbsp;&nbsp;
								@if ($c['questionData']['is_active'] == '1')
								 {{ "OFFERING"}}
								@elseif ($c['questionData']['is_active'] == '2') 
								 {{ "OFFERING"}}
								@elseif ($c['questionData']['is_active'] == '3')
								 {{"OFFERED"}}
								@elseif ($c['questionData']['is_active'] == '4') 
								 {{"OFFERED"}}
								@elseif ($c['questionData']['is_active'] == '5') 
								 {{"PAID"}}
								@endif
								 $ {{ $c['questionData']['question_worth']}}.00
							</span>
						</div>
					</a>
				</div>
				@endforeach
				@else
				<!-- <div class="thread-list-item">No Questions</div> -->
				@endif
			</div>
		</div>
		<div class="col-8 messages">
			<div class="toolbar">
				<div class="toolbar-name"></div>
				<!-- Melissa Townsend -->
			</div>
			<div class="messages-container" id="messages_container">
				<!-- <p style="text-align:center;">Select any question.</p> -->
			</div>

			@if(count($conversations) > 0)
			<div class="reply-container">

				<form id="send-message" method="POST" >
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="conv_id">
					<input type="hidden" name="ques_id">
					<textarea class="form-control" name="message" rows="4" placeholder="Your thoughtful answer…" style="display:none;" ></textarea>
					<div class="send_message_buttons" style="display:none;">
						<button type="submit" class="btn btn-primary float-right btn-sm accept_question">Answer and Accept $<span id="amount">0</span></button>
						<a href="#" data-id="" class="btn btn-outline-secondary decline-btn float-right btn-sm">Decline</a>
					</div>
					<button type="submit" class="btn btn-primary float-right btn-sm send_message_button" style="display:none;">Send message</button>
					
				</form>
				
			</div>
			@else
			@endif
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
									<div class="reviewer-name">
									{{ $review['seekerData']['first_name'] }} {{ $review['seekerData']['last_name'] }}</div>
								</div>
								<div class="col">
									<div class="text-right review-date">
										<?php
										$timestamp = strtotime($review['created_at']);
										$new_date_format = date('d F, Y ', $timestamp);
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
	<!-- DOWNLOAD EMAILS Modal -->
	<div class="modal fade" id="download-emails" tabindex="-1" role="dialog" aria-labelledby="download-emailsModal" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header app-modal-header">
					<h4 class="modal-title app-modal-title" id="download-emailsModal">Download Email Addresses</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="fas fa-times"></i></span>
					</button>
				</div>
				<div class="modal-body p-4">

					<p class="text-center">Download a list of emails from users who have opted-in to receive email communications from you.</p>
					<div class="text-center">
						<button class="btn btn-outline-secondary decline-btn text-center" data-dismiss="modal">Cancel</button>
						<a href="{{  url('/export_excel/excel') }}" class="btn btn-primary text-center">Download CSV</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- FORM EMBED Modal -->
	<div class="modal fade" id="form-embed" tabindex="-1" role="dialog" aria-labelledby="form-embedModal" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header app-modal-header">
					<h4 class="modal-title app-modal-title" id="form-embedModal">Embed Question Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true"><i class="fas fa-times"></i></span>
					</button>
				</div>
				<div class="modal-body p-4">
					<p>Embed this code on your website:</p>
					<?php
						$url =  url('').'/'.Auth::user()->name; 
						echo htmlentities('<iframe src="'.$url.'" width="500px" height="500px" ></iframe>');
					?>
					<div class="text-center">
						<button class="btn btn-outline-secondary decline-btn text-center" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('pagejs')
<script type="text/javascript">
	$(document).ready(function() {
		$("a.showMessages").on("click", function() {
			
			$("#messages_container").css("max-height", "350px");
			$("#messages_container").css("height", "350px");

			$('.thread-list-item').removeClass('active');
			$(this).parent('.thread-list-item').addClass('active');

			$(".send_message_button").css("display", "none");
			var id = $(this).attr("data-id");

			$.ajax({
				'url': '{{ url("dashboard/chat") }}/' + id,
				'method': 'get',
				'dataType': 'json',
				success: function(data) {
					if (data.status == 'success') {
						//alert(data.question_data['is_active']);
						if(data.question_data['is_active'] === '4' || data.question_data['is_active'] == '5')
						{
							$("textarea[name=message]").css("display", "none");
							$("#messages_container").css("max-height", "550px");
							$("#messages_container").css("height", "550px");
						}else{
							$("textarea[name=message]").css("display", "block");
						}
						
						$(".toolbar-name").text(data.name);
						$("#messages_container").html(data.messages);
						if (data.question_data['is_active'] == '3' || data.question_data['is_active'] == '4' || data.question_data['is_active'] == '5') {
							$("#messages_container").css("max-height", "550px");
							$("#messages_container").css("height", "550px");
							$("textarea[name=message]").css("display", "none");
							$(".send_message_buttons").css("display", "none");
							return false;
						}

						if (data.question_data['seeker_id'] == data.login_user) {
							$(".send_message_buttons").css("display", "none");
							$(".send_message_button").css("display", "block");
						}
						if (data.question_data['expert_id'] == data.login_user) {
							if (data.question_data['is_active'] == 2) {
								$(".send_message_buttons").css("display", "none");
								$(".send_message_button").css("display", "block");
							} else {
								$(".send_message_buttons").css("display", "block");
							}
						}

						$("textarea[name=message]").removeAttr("disabled");
						$("#messages_container").scrollTop(1000);
						$("input[name=conv_id]").val(id);
						$("input[name=ques_id]").val(data.question_data['id']);
						$("#amount").text(data.question_data['question_worth']);
						$(".decline-btn").attr("data-id", data.question_data['id']);
					}
				}
			});
			return false;
		});

		$(".send_message_button").on("click", function() {
			$("#messages_container").scrollTop(1000);
			$.ajax({
				'url': '{{ url("/sendMessage") }}',
				'method': 'post',
				'dataType': 'json',
				'data': $("#send-message").serialize(),
				success: function(data) {
					if (data.status == 'success') {
						$("#messages_container").html(data.messages);
						$("textarea[name=message]").val("");
					}
				}
			});
			return false;
		});

		$(".accept_question").on("click", function() {

			$.ajax({
				'url': '{{ url("/acceptQuestion") }}',
				'method': 'post',
				'dataType': 'json',
				'data': $("#send-message").serialize(),
				success: function(data) {
					if (data.status == 'success') {
						$("#messages_container").html(data.messages);
						$("textarea[name=message]").val("");
						$(".send_message_buttons").css("display", "none");
						$(".send_message_button").css("display", "block");
					}
				}
			});
			return false;
		});

		$("a.decline-btn").on("click", function() {
			var id = $(this).attr("data-id");
			$.ajax({
				'url': '{{ url("/userDecline") }}/' + id,
				'method': 'get',
				'dataType': 'json',
				success: function(data) {
					if (data.status == 'success') {
						$(".send_message_buttons").css("display", "none");
						$("textarea[name=message]").attr("disabled", "disabled");
						$(".thread-list-item").find("a[data-id=" + id + "]").children(".thread-info").find(".thread-status").text("DECLINED");
					}
				}
			});
			return false;
		});


		
	});
</script>
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
	<script>
		// CKEDITOR.replace( 'message' );
	</script>
@stop