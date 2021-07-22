@extends('layouts.inner')
@section('pageTitle', 'Change Password')
@section('pageCss')
@stop
@section('content')
@php
// dd($user_data);
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
        <div class="flex-grow-1">
            <p class="profile-name">Change Password</p>
        </div>

    </div>
    <form action="{{ url('/savePassword') }}" method="POST">
        @csrf
        <div>
            <p>Old Password :</p>
            <input type="password" class="form-control mr-2" id="oldPaasword" name="old_password" aria-describedby="oldPassword" placeholder="Old Password">
        </div>
        @if ($errors->has('old_password'))
        <span class="invalid-alert" role="alert">
            <strong>{{ $errors->first('old_password') }}</strong>
        </span>
        @endif

        <div>
            <p>New Password :</p>
            <input type="password" class="form-control mr-2" id="password" name="new_password" aria-describedby="newPassword" placeholder="New Password">
        </div>
        @if ($errors->has('new_password'))
        <span class="invalid-alert" role="alert">
            <strong>{{ $errors->first('new_password') }}</strong>
        </span>
        @endif

        <div>
            <p>Conform Password :</p>
            <input type="password" class="form-control mr-2" id="confirm_password" name="confirm_password" aria-describedby="conformPassword" placeholder="Conform Password">
        </div>
        @if ($errors->has('confirm_password'))
        <span class="invalid-alert" role="alert">
            <strong>{{ $errors->first('confirm_password') }}</strong>
        </span>
        @endif
        <span id='message'></span>
        <br />
        <br />
        <div class="d-flex">
            <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
    </form>
</div>

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

        $('#password, #confirm_password').on('keyup', function() {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else
                $('#message').html('Not Matching').css('color', 'red');
        });

    });
</script>
@endsection

@section('pagejs')

@stop