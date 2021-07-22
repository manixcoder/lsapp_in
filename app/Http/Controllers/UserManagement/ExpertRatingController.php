<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExpertRating;
use App\User;
use Auth;
use DB;

class ExpertRatingController extends Controller
{
    public function rateExpert(Request $request){
       // dd($request);
        $feedBackData = ExpertRating::create([
            'seeker_id' => $request->seeker_id,
            'expert_id' => $request->expert_id,
            'rating' => $request->ratingStar,
            'feed_back' => $request->feedBack
        ]);
        //return true;
        return response()->json(['status' => 'success', 'message' => 'Feed Back posted successfully.']);
        //return redirect('/')->with(['status' => 'danger', 'message' => 'User Profile you are serching not found!']);
        //return back()->with(['status' => 'success', 'message' => 'Feed Back posted successfully.']);
    }
    public function exportTip(Request $request){

        $questionData = DB::table('users_question')
            ->where('id', $request->question_id)
            ->first();
            
             // dd($questionData);
            
            $tolal_amount =  $questionData->question_worth + $request->tip_amount;

        $questionPrices = DB::table('users_question')
              ->where('id', $request->question_id)
              ->where('payment_status', 1)
              ->update(['question_worth' => $tolal_amount]);
        //return redirect('/dashboard')->with(['status' => 'success', 'message' => 'tip amount update successfully']);
        return response()->json(['status' => 'success', 'message' => 'tip amount update successfully.']);

    }
}
