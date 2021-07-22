@extends('layouts.auth')
@section('pageTitle', 'Login')

@section('pageCss')
 
@stop

@section('content')
	<div class="pl-3 pr-3">
	    <div class="sheet max-width-400">
	        <h1 class="header-dark-24 text-center">Log In</h1>

			<form action="{{ route('login') }}" method="post">
				@csrf
	            <div class="form-group">
	                <label for="emailAddress">Email Address</label>
						 
					 <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
	            </div>
	            <div class="form-group">
					<label for="password">Password</label>
					<div class="input-group" id="show_hide_password">
					
						<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						
						<div class="input-group-append">
							<span class="input-group-text" id="basic-addon2"><a href="" data-toggle="tooltip" data-placement="top" title="Show/Hide Password"><i class="fas fa-eye"></i></a></span>
						</div>
					</div>
				</div>
	            <div class="text-center">
	                <a href="{{ route('password.request') }}" class="font-14 text-center forgot-password">Forgot Password</a>
	            </div>
	            <button type="submit" class="btn btn-primary btn-lg btn-block" name="login-submit">Log In</button>
	        </form>
	        <p class="text-center mt-3 mb-0">or <a href="{{ route('register') }}">Create an Account</a></p>
	    </div>
    </div>
 
@endsection
