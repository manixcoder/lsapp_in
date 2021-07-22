@extends('layouts.inner')
@section('pageTitle', 'Transactions')

@section('pageCss')

@stop

@section('content')
<?php
    // dd($user_data);
?>
<div class="p-3">
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
    <!-- Single My Question -->
    <form class="form-horizontal" method="POST" action="{{ url('/edit-profile') }}" enctype="multipart/form-data">
        @csrf
        <div class="container sheet settings-sheet">
            <div class="settings-header-container">
                <div class="row">
                    <div class="col">
                        <p class="settings-main-header">Settings</p>
                    </div>
                    <div class="col">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-settings">
                <!-- Public Profile -->
                <p class="settings-section-header">Public Profile</p>
                <div class="row mt-3">
                    <div class="col-3">
                        @if($user_data['profile_photo'] !='')
                        <div class="settings-profile-photo" style="background-image:url('{{ asset('public/uploads/user_profiles/'.$user_data['profile_photo']) }}');"></div>
                        @else
                        <div class="settings-profile-photo" style="background-image: url('{{ asset('public/insightapp/images/profile-photo.jpg') }}')"></div>
                        @endif
                        <!-- <a href="#" class="d-block text-center mt-2 font-14">Upload Photo</a> -->
                        <input id="image" name="profile_photo" type="file" class="form-control">
                        @if ($errors->has('profile_photo'))
                        <span class="invalid-alert" role="alert">
                            <strong>{{ $errors->first('profile_photo') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-9">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="first_name" value="{{ $errors->has('first_name') ? old('first_name') : $user_data['first_name'] }}">
                                    @if ($errors->has('first_name'))
                                    <span class="invalid-alert" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{ $errors->has('last_name') ? old('last_name') : $user_data['last_name'] }}">
                                    @if ($errors->has('last_name'))
                                    <span class="invalid-alert" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="name"  value="{{ $errors->has('name') ? old('name') : $user_data['name'] }}">
                                    @if ($errors->has('name'))
                                    <span class="invalid-alert" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="text" class="form-control" name="website_url" value="{{ $errors->has('website_url') ? old('website_url') : $user_data['website_url'] }}">
                                    @if ($errors->has('website_url'))
                                    <span class="invalid-alert" role="alert">
                                        <strong>{{ $errors->first('website_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Profile Bio</label>
                            <textarea class="form-control" name="profile_bio" rows="3">{{ $errors->has('profile_bio') ? old('profile_bio') : $user_data['profile_bio'] }}</textarea>
                            @if ($errors->has('profile_bio'))
                            <span class="invalid-alert" role="alert">
                                <strong>{{ $errors->first('profile_bio') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Accept new questions from your profile:</label>
                            <div>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio"  name="is_accept_new_questions" id="termsRadio" value="Yes" <?php echo ($user_data['is_accept_new_questions'] == 'Yes' ? ' checked' : ''); ?>>
                                    <label class="form-check-label" for="termsRadio">Yes &nbsp;</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_accept_new_questions" id="termsRadio" value="No" <?php echo ($user_data['is_accept_new_questions'] == 'No' ? ' checked' : ''); ?> >
                                    <label class="form-check-label" for="termsRadio">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Payment Options -->
                <p class="settings-section-header">Payment Options</p>
                <p class="pb-0 mb-2">Payment choices for your profile’s question form.</p>
                
                <select name="payment_options" id="payment_options" class="custom-select payment-options-input">
                    <!-- <option value="" <?php  echo ($user_data['payment_options']=="")? 'selected="selected"' : '';  
                    ?>  >Select Price Range</option> -->
                    <option <?php  echo ($user_data['payment_options']=="price_Range")? 'selected="selected"' : ''; 
                    ?> value="price_Range" >Price Range</option>
                    <option <?php  echo ($user_data['payment_options']=="single_price")? 'selected="selected"' : ''; 
                    ?> value="single_price">Single Price</option>
                    <option value="free" <?php  echo ($user_data['payment_options']=="free")? 'selected="selected"' : ''; 
                    ?> >Free</option>
                    <!-- <option>C</option> -->
                </select>
                <div class="viewcontent price-range-rad" id="price_ranges" style="display: <?php  echo ($user_data['payment_options']=="price_Range")? 'block' : 'none'; 
                    ?> ;">
                    <p class="pb-0 mt-4 mb-3">Choose your price range.</p>

                <div class="form-check payment-options-container">
                    <input class="form-check-input price-range-rad" type="radio" name="price_range" id="price-range-radios-1" value="option1" <?php echo ($user_data['price_range'] == 'option1' ? ' checked' : ''); ?>>
                    <img src="{{ asset('public/insightapp') }}/images/price-range-1.png" class="price-range-option-img">
                </div>
                <div class="form-check payment-options-container">
                    <input class="form-check-input price-range-rad" type="radio" name="price_range" id="price-range-radios-2" value="option2" <?php echo ($user_data['price_range'] == 'option2' ? ' checked' : ''); ?>>
                    <img src="{{ asset('public/insightapp') }}/images/price-range-2.png" class="price-range-option-img">
                </div>
                <div class="form-check payment-options-container">
                    <input class="form-check-input price-range-rad" type="radio" name="price_range" id="price-range-radios-3" value="option3"  <?php echo ($user_data['price_range'] == 'option3' ? ' checked' : ''); ?>>
                    <img src="{{ asset('public/insightapp') }}/images/price-range-3.png" class="price-range-option-img">
                </div>
                <div class="form-check payment-options-container">
                    <input class="form-check-input price-range-rad" type="radio" name="price_range" id="price-range-radios-4" value="option4" <?php echo ($user_data['price_range'] == 'option4' ? ' checked' : ''); ?>>
                    <img src="{{ asset('public/insightapp') }}/images/price-range-4.png" class="price-range-option-img">
                </div>
                </div>
                <div class="viewcontent" id="price_custom" style="display: <?php  echo ($user_data['payment_options']=="single_price")? 'block' : 'none'; 
                    ?>;">
                    <p class="pb-0 mb-2">Enter custom Price :</p>
                    
                    <input class="form-check-input price-range-rad" type="number"  name="single_price" value="{{ $errors->has('single_price') ? old('single_price') : $user_data['single_price'] }}" placeholder="$">
                    <br>
                    @if ($errors->has('single_price'))
                    <span class="invalid-alert" role="alert">
                        <strong>{{ $errors->first('single_price') }}</strong>
                    </span>
                    @endif

                </div>
                <p class="font-12 mt-4">There is a small transaction fee for every payment you recieve which covers credit card fees and operational costs. Free questions are not charged any fees. View Insight’s <a href="#" target="_blank">transaction fees</a>.</p>
                <!-- Link Bank Account -->
                <p class="settings-section-header">Link Bank Account</p>
                <p class="pb-0 mb-2">This is how you get paid.</p>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Street Address</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label>Bank Routing Number</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Bank Account Number</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Zip Code</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- Link Bank Account -->
                <p class="settings-section-header">Notifications</p>
                <p class="pb-0 mb-2">Email notification settings.</p>
                <div class="form-check mb-2">
                <input type="hidden" name="is_newQuestionArrivedNotification" value='0'>
                    <input class="form-check-input" type="checkbox" value="1"<?php if ($user_data['is_newQuestionArrivedNotification'] === '1') {
                                                                                    echo "checked='checked'";
                                                                                } else {
                                                                                    echo "";
                                                                                } ?> id="email-checkbox-1" name="is_newQuestionArrivedNotification">
                    <label class="form-check-label" for="email-checkbox-1">Get notified when a new question arrives</label>
                </div>
                <div class="form-check mb-2">
                <input type="hidden" name="is_reply_to_your_answer" value='0'>
                    <input class="form-check-input" type="checkbox" value="1" id="email-checkbox-2" <?php if ($user_data['is_reply_to_your_answer'] === '1') {
                                                                                                        echo "checked='checked'";
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?> name="is_reply_to_your_answer">
                    <label class="form-check-label" for="email-checkbox-2">Get notified when you receive a reply to your answer</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="1" id="email-checkbox-3" <?php if ($user_data['is_expert_response_to_question'] === '1') {
                                                                                                        echo "checked='checked'";
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?> name="is_expert_response_to_question">
                    <label class="form-check-label" for="email-checkbox-3">Get notified when an expert responds to your question</label>
                </div>
                <div class="form-check">
                    <input type="hidden" name="is_marketing_messages" value='0'>
                    <input class="form-check-input" type="checkbox" value="1" id="email-checkbox-4" <?php if ($user_data['is_marketing_messages'] === '1') {
                                                                                                        echo "checked='checked'";
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?> name="is_marketing_messages">
                    <label class="form-check-label" for="email-checkbox-4">Marketing messages</label>
                </div>
                <!-- Link Bank Account -->
                <p class="settings-section-header">ACCOUNT</p>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Change Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ $errors->has('email') ? old('email') : $user_data['email'] }}">
                            @if ($errors->has('email'))
                                    <span class="invalid-alert" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                        </div>
                    </div>
                </div>
                <p><a href="{{ url('/change-password') }}">Change Password</a></p>
                <p><a href="#" class="delete-red">Delete Account</a></p>


            </div>
            <div class="settings-footer-container">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        function validate(form) {
            var re = /^[a-z,A-Z]+$/i;
            if (!re.test(form.name.value)) {
                alert('Please enter only letters from a to z');
                return false;
            }
        }

        $("#payment_options").change(function () {
            var selectedValue = $(this).val();
            $(".viewcontent").css('display','none');
           //alert("Selected Text: " + selectedText + " Value: " + selectedValue);
           if(selectedValue =='single_price')
           {
                $("#price_custom").css('display','block');
           }
           if(selectedValue =='price_Range')
           {
                $("#price_ranges").css('display','block');
           }
        });
</script>
</div>
@endsection

@section('pagejs')
@stop