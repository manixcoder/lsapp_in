@if(!$data->isEmpty())
	@foreach($data as $d)
	<?php // dd($d); ?>
		@if($d['user_id'] != Auth::user()->id)
		<div class="single-message-recipient d-flex">
			@if($d['sender']['profile_photo'] !='')
			<div class="recipient-photo" style="background-image: url('{{ asset('public/uploads/user_profiles/'.$d['sender']['profile_photo'] ) }}')"></div>
			@else
			<div style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')" class="recipient-photo"></div>
			@endif
			<div class="flex-grow-1">
				<div class="single-message-recipient-text" style="text-align:justify;">{{ $d['body'] }}</div>
				<div class="single-message-recipient-date"> {{ $d['created_at']->format('M d, Y H:ia') }}</div>
			</div>
		</div>
		@else
		<!-- SENDER -->
		<div class="single-message-sender d-flex">
			<div class="flex-grow-1">
				<div class="single-message-sender-text">
					{{ $d['body'] }}
				</div>
				<div class="single-message-sender-date">{{ $d['created_at']->format('M d, Y H:ia') }}</div>
			</div>
			<!-- <div class="sender-photo" style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')"></div> -->

			@if($d['sender']['profile_photo'] !='')
			<div class="sender-photo" style="background-image: url('{{ asset('public/uploads/user_profiles/'.$d['sender']['profile_photo'] ) }}')"></div>
			@else
			<div style="background-image:url('{{ asset('public/insightapp') }}/images/profile-photo.jpg')" class="sender-photo"></div>
			@endif
		</div>
		@endif
	@endforeach
@else
	<p style="text-align:center;">No chat.</p>
@endif