@extends('layouts.auth_without')
@section('pageTitle', 'Reset Password')
@section('content')
<div class="pl-3 pr-3">
	<div class="sheet max-width-400">
	        <h1 class="header-dark-24 text-center">Reset Password</h1>
            <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                <input type="hidden" name="token" value="{{ $token }}">
               
                <div class="form-group" style="display: none;">
                    <label for="email">E-Mail Address</label>
                    <div class="input-group" id="email">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                         
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><a href="" data-toggle="tooltip" data-placement="top" title="Show/Hide Password"><i class="fas fa-eye"></i></a></span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Re-type New Password</label>
                    <div class="input-group" id="show_hide_password">
                        <!-- <div class="col-md-6"> -->
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <!-- </div> -->
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><a href="" data-toggle="tooltip" data-placement="top" title="Show/Hide Password"><i class="fas fa-eye"></i></a></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Reset Password') }}
                </button>
                
            </form>
    </div>
</div> 
@endsection
