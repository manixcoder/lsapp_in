@extends('layouts.inner')
@section('pageTitle', 'Transactions')
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
    <h1 class="text-center main-header">Transactions</h1>
    <!-- Single My Question -->
    <div class="container sheet transactions-sheet">
    <?php 
        $totle=0;
        foreach($question_data as $qData){
            $totle += $qData->question_worth; 
        }
    ?>
    <div class="transactions-header-container">
            <div class="row">
                <div class="col">
                    <p class="dash-stat-header">Available Balance</p>
                    <!-- <p class="dash-stat mb-0 pb-0">$287.00</p> -->
                    <p class="dash-stat mb-0 pb-0">${{ $totle }}.00</p>
                </div>
                <div class="col">
                    <div class="text-right">
                        <a href="{{ url('/dashboard/payoutRequest') }}" class="btn btn-primary mt-1">Request Payout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-transactions">
            @forelse($question_data as $qData)
            <div class="row">
                <div class="col-3">
                    <!-- <p>03/14/2019</p> -->
                    <p>{{ date('m/d/Y', strtotime($qData->created_at)) }}</p>
                </div>
                <div class="col-6">
                    <!-- <p>Answered Question</p> -->
                    <p>
                        <?php
                            if ($qData->is_active == '1') {
                                echo  "<p>OPEN QUESTION";
						} elseif ($qData->is_active == '2') {
							echo "ANSWERED";
						} elseif ($qData->is_active == '3') {
							echo  "<p>DECLINED</p>";
						} elseif ($qData->is_active == '4') {
							echo  "<p>EXPIRED</p>";
						}elseif ($qData->is_active == '5') {
							echo  "Answered Question";
						}
                        ?>
                        </p>
                </div>
                <div class="col-3">
                    <!-- <p class="text-right">$22.50</p> -->
                    <p class="text-right"> 
                        @if($qData->payment_status =='1')
                        {{ "-"}}
                        @else
                        {{ "+" }}
                        @endif
                        $ {{ $qData->question_worth }}.00</p>
                </div>

                
            </div>
            @empty
            <div class="row">
            <div class="col-6">
                    <p>No record</p>
                </div>
                
            </div>
            @endforelse

            <!-- <div class="row">
                <div class="col-3">
                    <p>03/14/2019</p>
                </div>
                <div class="col-6">
                    <p>Answered Question</p>
                </div>
                <div class="col-3">
                    <p class="text-right">$22.50</p>
                </div>
            </div> -->
        </div>
    </div>

    <p class="text-center font-12">View Insight's <a href="#" target="_blank">transaction fees</a>.</p>

    @endsection

    @section('pagejs')
    @stop