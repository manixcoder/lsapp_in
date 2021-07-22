@extends('layouts.auth')
@section('pageTitle', 'Create New Account')

@section('pageCss')
 
@stop
@section('content')

<div class="pl-3 pr-3">
	<div class="sheet max-width-400">
		<h1 class="header-dark-24 text-center">Create an Account</h1>
		<?php /*
		<pre>
		{{ print_r($errors)  }}
		</pre>
		@if ($errors->any())
			 @foreach ($errors->all() as $error)
				 <div>{{$error}}</div>
			 @endforeach
		@endif
		
		*/ ?>
		
		<form method="POST" action="{{ route('register') }}">
                        @csrf
			<div class="row">
				<div class="col padding-right-5">
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

						@error('first_name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>
				<div class="col padding-left-5">
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

						@error('last_name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="emailAddress">Email Address</label>
			 
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="form-group">
				<label for="name">Username</label>
				
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

						@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<div class="input-group" id="show_hide_password">
					 
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
					<div class="input-group-append @error('password') is-invalid @enderror">
						<span class="input-group-text  @error('password') is-invalid @enderror" id="basic-addon2"><a href="" data-toggle="tooltip" data-placement="top" title="Show/Hide Password"><i class="fas fa-eye"></i></a></span>
					</div>
					
					@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
			</div>
				
			<div class="form-group">
				<label for="termsRadio" class="font-14 d-block">I agree to the <a href="{{ url('/terms') }}">terms</a> and <a href="{{ url('/privacy') }}">privacy policy</a>.</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio"  name="termsRadio" id="termsRadio"  value="yes"  >
					<label class="form-check-label font-14" for="termsRadio">Yes</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" checked name="termsRadio" id="termsRadioNo"  value=""  >
					<label class="form-check-label font-14" for="termsRadioNo">No</label>
				</div>
				
				@error('termsRadio')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<div class="form-group">
				<label for="is_marketing_messagesYes" class="font-14 d-block">I’d like to receive email marketing messages.</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio"  name="is_marketing_messages" id="is_marketing_messagesYes" value="1">
					<label class="form-check-label font-14" for="is_marketing_messagesYes">Yes</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" checked name="is_marketing_messages" id="is_marketing_messagesNo" value="0">
					<label class="form-check-label font-14" for="is_marketing_messagesNo">No</label>
				</div>
				
				@error('is_marketing_messages')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
				
			<button type="submit" class="btn btn-primary btn-lg btn-block" name="create-account-submit">Create an account</button>
		</form>
		<p class="text-center mt-3 mb-0">Already have an account? <a href="{{ route('login') }}">Log In</a></p>
		
	</div>
</div>
		
 
@endsection
