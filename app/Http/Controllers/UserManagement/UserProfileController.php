<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Auth;
use Carbon;
use App\Models\ExpertRating;
use App\Models\UserProfile;
class UserProfileController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth']);
    }
    /**
     * Dashboard landing function 
     *
     * @return void
     */
    public function profile($username)
    {
        //dd($username);
        if (Auth::guest()) {
            $user_data = User::where('name', $username)->first();
            $ratingReview = ExpertRating::with(['seekerData'])->where('expert_id', $user_data['id'])->get();
            $ratingData = DB::table('expert_rating')->where('expert_id', $user_data['id'])->get();
            $stripe_token = '';
        } else {
            $user_data = User::where('name', $username)->first();
            $ratingReview = ExpertRating::with(['seekerData'])->where('expert_id', $user_data['id'])->get();
            $ratingData = DB::table('expert_rating')->where('expert_id', $user_data['id'])->get();
            $stripe_token = Auth::user()->stripe_token;

            if (Auth::user()->stripe_token = '') {
                return view('user.user_creditDetail');
            }
            if(!empty($user_data)){
                if (Auth::user()->id != $user_data['id']) {

                    $visitorData = DB::table('visitors')
                        ->where('user_id', Auth::user()->id)
                        ->where('visitor_id', $user_data['id'])
                        ->get();
                        //dd($visitorData);

                        // if ($visitorData->isEmpty()) 
                        // {
                            DB::table('visitors')->insert([['user_id' => Auth::user()->id, 'visitor_id' => $user_data['id'], 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]]);
                        //}
                    }
                }
                else
                {
                    return redirect('/')->with(['status' => 'danger', 'message' => 'User Profile you are serching not found!']);
                }
            }
            //dd($ratingReview);
            if(!empty($user_data))
            {
                //dd($ratingData);
                $i = 0;
                $m = 0;
                foreach ($ratingData as $rate){
                    $i += $rate->rating;
                    $m++;
                }
                if ($i > 0) 
                {
                    $averageRating = $i / $m;
                } 
                else 
                {
                    $averageRating = 0;
                }
                $averageRating = round($averageRating);
                if ($m > 0) 
                {
                    $totalReview = $m;
                } 
                else 
                {
                    $totalReview = 0;
                }
                return view('user.profile_view')->with([
                    'user_data' => $user_data,
                    'ratingValue' => $averageRating,
                    'totalReview' => $totalReview,
                    'stripe_token' => $stripe_token,
                    'ratingReview' => $ratingReview
                ]);
            }
            else
            {
                return redirect('/')->with(['status' => 'danger', 'message' => 'User not found!']);
            }
        }
    }
