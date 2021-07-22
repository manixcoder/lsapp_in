@extends('layouts.auth')
@section('pageTitle', 'Reset Password')

@section('content')

<div class="pl-3 pr-3">
    <div class="sheet max-width-400">
        <h1 class="header-dark-24 text-center">Reset Password</h1>
        <p class="text-center reset-password-text">An email will be sent to you with instructions on how to reset your password.</p>
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-3" name="reset-request-submit">Send Password Reset</button>
        </form>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
 
@endsection
