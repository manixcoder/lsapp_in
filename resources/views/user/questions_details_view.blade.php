@extends('layouts.inner')
@section('pageTitle', 'My Questions')
@section('pageCss')
@stop
@section('content')
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
    <?php 
     //dd($user_data['is_active']);
    ?>
<div class="container max-width-600">
	<a href="{{ url('/my-questions') }}" class="back-link"><i class="fas fa-arrow-left"></i> &nbsp;Back</a>
	<!-- Single My Question -->
	<div class="container sheet question-detail-sheet" id="sheet_q">
		<div class="question-header-detail">
			<p class="question-detail-header-name text-center">{{ $user_data['expertsData']['first_name'] }} {{ $user_data['expertsData']['last_name'] }}</p>
			<p class="question-detail-header-link text-center"><a href="{{ url('/') }}/{{ $user_data['expertsData']['name'] }}">View Profile</a></p>
		</div>

		<div class="messages-container">
			@if(!$messages->isEmpty())
				@foreach($messages as $d)
					@if($d['user_id'] != Auth::user()->id)
					<div class="single-message-recipient d-flex">
						@if($d['sender']['profile_photo'] !='')
						<div class="recipient-photo" style="background-image: url('{{ asset('public/uploads/user_profiles/'.$d['sender']['profile_photo'] ) }}')"></div>
						@else
						<div style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')" class="recipient-photo"></div>
						@endif
						<!-- <div style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')" class="recipient-photo"></div> -->
						<div class="flex-grow-1">
							<div class="single-message-recipient-text">{{ $d['body'] }}</div>
							<div class="single-message-recipient-date"> {{ $d['created_at']->format('M d, Y H:ia') }}</div>
						</div>
					</div>
					@else
					<div class="single-message-sender d-flex">
						<div class="flex-grow-1">
							<div class="single-message-sender-text">
								{{ $d['body'] }}
							</div>
							<div class="single-message-sender-date"> {{ $d['created_at']->format('M d, Y H:ia') }}</div>
						</div>
						@if($d['sender']['profile_photo'] !='')
						<div class="sender-photo" style="background-image: url('{{ asset('public/uploads/user_profiles/'.$d['sender']['profile_photo'] ) }}')"></div>
						@else
						<div style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')" class="sender-photo"></div>
						@endif
						<!-- <div class="sender-photo" style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')"></div> -->
					</div>
					@endif
				@endforeach
			@endif
			@if($user_data['is_active'] =='3')
			<div class="single-message-sender d-flex">
				<div class="flex-grow-1">
					<div class="single-message-sender-text">
						<h6>{{ $user_data['expertsData']['first_name'] }} decline this question.</h6>
						<span>Question are typically declined becouse the export did not fee confident in giving a quality answer.You ware not charged for this question.</span>
					</div>
				</div>
			</div>
			@else
			@endif


		</div>
		<div class="reply-container" id="replymessage"  style="display: none">
			@if($user_data['is_active'] =='3')
			
			@else
			<form id="send-message" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="conv_id" value="{{$conversation->conversation_id}}">
				<input type="hidden" name="ques_id" value="{{$conversation->question_id}}">
				<textarea class="form-control" name="message" rows="4" placeholder="Your thoughtful answer…"></textarea>
				<!-- <br /> -->
				<button type="submit" class="btn btn-primary float-right btn-sm send_message_button">Send Massage</button>
				<a href="#" id="cancelmessage" class="btn btn-primary float-right btn-sm cancel_question">Cancel</a>
			</form>
			@endif
		</div>
		<div class="reply-container" id='reply-container'>
			
			@if($user_data['seeker_id'] == Auth::user()->id && $user_data['is_active'] != 3)
				<button id="rateanswer" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#reviews">Rate this answer</button>
			@endif
			@if($user_data['is_active'] != 5 && $user_data['is_active'] != 3)
				<a href="#" id="reply" class="btn btn-outline-secondary reply-btn float-right btn-sm" >Reply</a>
				<button type="submit" id="complete" class="btn btn-outline-secondary complete-btn float-right btn-sm" onclick="event.preventDefault();document.getElementById('mark-as-complete-form').submit();">Mark as complete</button>

			@endif
		</div>
		<form id="mark-as-complete-form" method="POST" action="{{ url('/mark-as-complete') }}" style="display:none;">
			@csrf
			<input type="hidden" name="ques_id" value="{{ $user_data['id'] }}">
		</form>
		<!-- modal start -->
			<div class="modal fade show feedback" id="reviews" tabindex="-1" role="dialog" aria-labelledby="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<!-- REVIEW -->
							<form id="feedbakd" action="" method="Post" >
							@csrf
								<input type="hidden" name="seeker_id" value="{{ $user_data['seeker_id']}}">
								<input type="hidden" name="expert_id" value="{{ $user_data['expert_id']}}">
								<div class="single-review">
									@if($user_data['expertsData']['profile_photo'])
									<div style="background-image:url('{{ asset('public/uploads/user_profiles/'.$user_data['expertsData']['profile_photo'] ) }}')" class="user-photo"></div>
									@else
									<div style="background-image:url('https://static8.depositphotos.com/1167812/876/i/950/depositphotos_8760055-stock-photo-headshot-of-a-young-man.jpg')" class="user-photo"></div>
									@endif
									<div class="flex-grow-1 feedback-single">
										<div class="row">
											<div class="reviewer-name">Leave Feedback For<br>
											{{ $user_data['expertsData']['first_name'] }} {{ $user_data['expertsData']['last_name'] }} 
											</div>
											<div class="static-msg">Please rate your satisfaction with {{ $user_data['expertsData']['first_name'] }}'s answer.</div>
											<div class="rate-options">
												<select name="ratingStar" class="custom-select feedback-star-input">
													<option value="5">&#9733; &#9733; &#9733; &#9733; &#9733;</option>
													<option value="4">&#9733; &#9733; &#9733; &#9733;</option>
													<option value="3">&#9733; &#9733; &#9733;</option>
													<option value="2">&#9733; &#9733;</option>
													<option value="1">&#9733;</option>
												</select>
											</div>
										</div>
										<!-- <p class="review-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></p> -->
										<div class="reviewer-feedback">
											<p>Leave feedback (optional)</p>
											<textarea name="feedBack" id="" cols="30" rows="10"></textarea>
										</div>
										<div class="reviewe-complete">
											<p>By leaving feedback you are marking your question as complete</p>
											<button type="submit" class="btn btn-primary float-right btn-sm" id="feedback" data-toggle="modal" data-target="#user_tip">Leave FeedBack</button>
										</div>
									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>

			<div class="modal fade show feedback" id="user_tip" tabindex="-1" role="dialog" aria-labelledby="tipModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<!-- TIPS -->
							<form action="#" id="tipform" method="Post" >
								@csrf
								<input type="hidden" name="seeker_id" value="{{ $user_data['seeker_id']}}">
								<input type="hidden" name="expert_id" value="{{ $user_data['expert_id']}}">
								<input type="hidden" name="question_id" value="{{ $conversation->question_id}}">
								<div class="single-review">
									@if($user_data['expertsData']['profile_photo'])
									<div style="background-image:url('{{ asset('public/uploads/user_profiles/'.$user_data['expertsData']['profile_photo'] ) }}')" class="user-photo"></div>
									@else
									<div style="background-image:url('https://static8.depositphotos.com/1167812/876/i/950/depositphotos_8760055-stock-photo-headshot-of-a-young-man.jpg')" class="user-photo"></div>
									@endif
									
									<div class="flex-grow-1 feedback-single">
										<div class="row">
											<div class="reviewer-name">Leave Tip For<br> {{ $user_data['expertsData']['first_name'] }} {{ $user_data['expertsData']['last_name'] }} 
											</div>
											<div class="static-msg">Would you like to leave a tip for {{ $user_data['expertsData']['first_name'] }} {{ $user_data['expertsData']['last_name'] }} ?</div>
											<div class="rate-options">
												<input class="form-control tip-input" type="number" pattern="[0-9]" name="tip_amount" onkeypress="isInputNumber(event)" placeholder="$">
											</div>
										</div>
										<!-- <div class="text-center">
											<a href="" class="btn btn-outline-secondary" >No Thanks</a>&nbsp;
											<button class="btn btn-primary btn-tip" id="leavetip">Leave Tip</button>
										</div> -->
										<div class="reviewe-complete">
											<button class="btn btn-primary float-right btn-tip" id="leavetip" >Leave Tip</button>
											<a href="" class="btn btn-primary float-right btn-tipCancel" >No Thanks</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

	</div>
	<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
	<script>
		// CKEDITOR.replace( 'message' );
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
		$("a#reply").on("click", function() {
			$('#replymessage').css('display','block');
			$('#reply-container').css('display','none');

		});

		$("a#cancelmessage").on("click", function() {
			$('#reply-container').css('display','block');
			$('#replymessage').css('display','none');

		});

		$(".send_message_button").on("click", function() {
			$(".messages-container").scrollTop(1000);
			$.ajax({
				'url': '{{ url("/sendMessage") }}',
				'method': 'post',
				'dataType': 'json',
				'data': $("#send-message").serialize(),
				success: function(data) {
					if (data.status == 'success') {
						$(".messages-container").html(data.messages);
						$("textarea[name=message]").val("");
					}
				}
			});
			return false;
		});


		$("#feedback").on("click", function() {
			$.ajax({
				'url': "{{url('/rateExpert')}}",
				'method': 'post',
				'dataType': 'json',
				'data': $("#feedbakd").serialize(),
				success: function(data) {
					if (data.status == 'success') {
						$("#reviews").modal('toggle');
						$("#user_tip").modal('toggle');
						//$(".messages-container").html(data.messages);
						//$("textarea[name=message]").val("");
					}
				}
			});
			return false;
		});

		$("#leavetip").on("click", function() {
			
			$.ajax({
				'url': "{{url('/exportTip')}}",
				'method': 'post',
				'dataType': 'json',
				'data': $("#tipform").serialize(),
				success: function(data) {
					if (data.status == 'success') {
						//$("#reviews").modal('toggle');
						$("#user_tip").modal('toggle');
						//$(".messages-container").html(data.messages);
						//$("textarea[name=message]").val("");
					}
				}
			});
			return false;
		});

		function isInputNumber(evt){
			var char = String.fromCharCode(evt.which);
			if(!(/[0-9]/.test(ch))){
				evt.preventDefault();
			}
		}
	});
	</script>



	

</div>
@endsection
@section('pagejs')
@stop