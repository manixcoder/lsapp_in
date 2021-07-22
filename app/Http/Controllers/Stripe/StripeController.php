<?php

namespace App\Http\Controllers\Stripe;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\UserProfile;

use Notification;
use App\Notifications\Export\ExportActionOnQuestion;
use App\Notifications\Seeker\SeekerActionQuestion;
use Musonza\Chat\Models\ConversationUser;
use Musonza\Chat\Models\MessageNotification;
use Auth;
use Chat;
use Carbon;
use App\Models\ExpertRating;
use DateTime;
use Stripe\Account;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function __construct()
    {
        //dd(env('STRIPE_SECRET'));
        // \Stripe\Stripe::setApiKey("sk_test_HN0OFxNDOXnZkXGSl6WDZrUo");
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->middleware(['auth']);
    }
    public function payoutRequest()
    {
        $question_data = DB::table('users_question')
            ->where('expert_id', Auth::user()->id)
            ->where('is_active', '5')
            ->where('payment_status', '1')
            ->get();
            if (!$question_data->isEmpty()) 
            {
                try {
                    foreach ($question_data as  $question) {
                        $seekerData = DB::table('users')->where('id', $question->seeker_id)->first();
                        $question_worth =  $question->question_worth;
                        $amount = $question_worth * 100;
                        if ( in_array($question_worth, range(1,15)) ) 
                        {
                            $fee =  $question_worth * 15 / 100 + 0.30 *100;
                        }
                        if ( in_array($question_worth, range(15,250)) )
                        {
                            $fee =  $question_worth * 10 / 100 * 100;
                        }
                        /*$amount = $question_worth * 100;
                        $fee =  $amount * 15 / 100 + 0.30 * 100;
                        $remainAmount = $amount - $fee;
                        $remainAmount = $remainAmount;*/
                        $description = "Insight App Question";
                        $charge = \Stripe\Charge::create([
                            // "amount" => $remainAmount,
                            "amount" => $amount,
                            "currency" => "usd",
                            //"source" => $token,
                            "customer" => $seekerData->stripe_token,
                            "application_fee"  => $fee,
                            "transfer_data" => [
                                "destination" => Auth::user()->stripe_user_id,
                            ],
                            "description" => $description,
                        ]);
                        if ($charge['status'] == 'succeeded')
                        {
                            DB::table('users_question')
                            ->where('id', $question->id)
                            ->update([
                                'payment_status' => '0',
                                'transaction_id' => $charge['transfer']
                            ]);
                        }
                    }
                    if ($charge['status'] == 'succeeded')
                    {
                        return back()->with(['status' => 'success', 'message' => 'Payment done successfully.']);
                    }
                }catch (\Stripe\Error\Card $e){
                    return response()->json($e->getJsonBody());
                } catch (\Stripe\Error\RateLimit $e) {
                    return response()->json($e->getJsonBody());
                } catch (\Stripe\Error\InvalidRequest $e) {
                    return back()->with(['status' => 'danger', 'message' => 'User Not verifie his credit/debit card.']);
                } catch (\Stripe\Error\Authentication $e) {
                    return response()->json($e->getJsonBody());
                } catch (\Stripe\Error\ApiConnection $e) {
                    return response()->json($e->getJsonBody());
                } catch (\Stripe\Error\Base $e) {
                    return response()->json($e->getJsonBody());
                } catch (Exception $e) {
                    return response()->json($e->getJsonBody());
                }
            } else {
                return back()->with(['status' => 'danger', 'message' => 'Payment Allready done.']);
            }
        }
    }
