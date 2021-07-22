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
<div class="p-3">
	<h1 class="text-center main-header">My Questions</h1> 
	<!-- Single My Question -->
	@if (count($user_data) > 0)
	@foreach($user_data as $userData)

	<a href="{{ url('/question-detail') }}/{{ $userData['conv_id'] }}" class="no-decoration open-question-details">
		<div class="container sheet my-questions-sheet">
			@if( $userData['expertsData']['profile_photo'])
			<div class="user-photo-my-questions" style="background-image:url('{{ asset('public/uploads/user_profiles/'.$userData['expertsData']['profile_photo']) }}')"></div>
			@else
			<div class="user-photo-my-questions" style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')"></div>
			@endif
			<div>
				<div class="d-flex">
					@php
					$date = ($userData['created_at'])->format('M d, Y H:ia');
					@endphp
					<div class="thread-name flex-fill">{{ $userData['expertsData']['first_name'] }} {{ $userData['expertsData']['last_name'] }}</div>
					<div class="thread-date">{{ $date  }}</div>
				</div>
				<div class="thread-message msg">
					{{ $userData['question_text'] }}
				</div>
				<div class="thread-info">
					<span class="thread-status">
						@if ($userData['is_active'] == '1')
						<span class="que_open">OPEN QUESTION</span>
						@elseif ($userData['is_active'] == '2')
						<span class="que_open"> OPEN QUESTION </span>
						<!-- <div class="que_accept">ACCEPTED</div> -->
						@elseif ($userData['is_active'] == '3')
						<span class="que_decline"> <i class="fa fa-times"></i> DECLINED </span>
						@elseif ($userData['is_active'] == '4')
						<span class="que_expire"> <i class="fa fa-times"></i> EXPIRED </span>
						@elseif ($userData['is_active'] == '5') 
						<span class="que_complete"> <i class="fa fa-check"></i> COMPLETED </span>
						@endif
					</span>
					<span class="thread-offer"> &nbsp; • &nbsp;
						@if ($userData['is_active'] == '1') 
							{{"OFFERING"}}
						@elseif ($userData['is_active'] == '2') 
							{{ "OFFERING"}}
						@elseif ($userData['is_active'] == '3') 
							{{"OFFERED"}}
						@elseif ($userData['is_active'] == '4') 
							{{"OFFERED"}}
						@elseif ($userData['is_active'] == '5') 
							{{"PAID"}}
						@endif  : ${{ $userData['question_worth'] }}.00</span>
				</div>
			</div>
		</div>
	</a>
	@endforeach
	@else
	<div class="container sheet my-questions-sheet">
		<div class="thread-message msg">No Questions</div>
	</div>
	@endif
</div>
@endsection
@section('pagejs')
@stop