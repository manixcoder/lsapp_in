<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;
use Hash;
use Mail;
use Illuminate\Validation\Rule;
use DB;
use App\Models\UserProfile;

use Notification;
use App\Notifications\Export\ExportActionOnQuestion;
use App\Notifications\Seeker\SeekerActionQuestion;
use Musonza\Chat\Models\ConversationUser;
use Musonza\Chat\Models\MessageNotification;
use Chat;
use Carbon;
use App\Models\ExpertRating;
use DateTime;
use Stripe\Account;
use Stripe\Stripe;
use Newsletter;

class UserManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $this->middleware(['auth']);
    }
    /**
     * Dashboard landing function
     * @return void
     */
    public function index()
    {

        $conversationData = DB::table('mc_conversation_user')
            ->where('user_id', Auth::user()->id)
            ->get();
        if (!$conversationData->isEmpty()) {
            foreach ($conversationData as $conversation) {
                $conversation_id =  $conversation->conversation_id;
                //$users = DB::connection($this->co)->select('SELECT a.id ,  a.created_at , b.created_at - a.created_at as Difference FROM mc_message_notification a JOIN mc_message_notification b ON a.conversation_id = '$conversation_id' AND a.created_at <> b.created_at');
                $results = DB::select('SELECT a.id ,  a.created_at , b.created_at - a.created_at as Difference FROM mc_message_notification a JOIN mc_message_notification b ON a.conversation_id = :id AND a.created_at <> b.created_at', ['id' => $conversation_id]);
                // dd($results);
            }
            //dd($results);
            if (!empty($results)) {
                foreach ($results as $res) {
                    $averageTime = $res->Difference;
                    // foreach ($res as $re) {
                    //     dd($re);
                    //     $averageTime = $re->Difference;
                    // }
                }
                if ($averageTime > 0) {
                    $averageTime = $averageTime;
                } else {
                    $averageTime = 0;
                }
            } else {
                $averageTime = 0;
            }
        } else {
            $averageTime = 0;
        }



        $userDetails = Auth::user();
        $questionData = DB::table('users_question')
            ->where('is_active', 1)
            ->orderBy('id', 'DESC')
            ->get();
        if ($questionData) {
            foreach ($questionData as $question) {
                $createdAt = $question->created_at;
                $arr = explode(" ", $createdAt);

                $date2date = date("Y-m-d");
                $date1 = new DateTime($arr[0]);
                $date2 = new DateTime($date2date);
                $interval = $date1->diff($date2);
                // dd($interval);
                if ($interval->days >= 7) {
                    DB::table('users_question')
                        ->where('id', $question->id)
                        ->update(['is_active' => 4]);
                }
            }
        }

        $next_due_date = date("Y-m-d H:i:s", strtotime("-30 days"));


        $visitorData = DB::table('visitors')
            ->where('user_id', Auth::user()->id)
            ->where('created_at', '>=', "'$next_due_date'")
            //->where('created_at', '<=', Carbon::now())
            ->get();
        //dd($visitorData);
        if (!$visitorData->isEmpty()) {
            $visitorNum = count($visitorData);
        } else {
            $visitorNum = 0;
        }


        $question_data = DB::table('users_question')
            ->where('expert_id', Auth::user()->id)
            ->where('is_active', '5')
            //->where('payment_status', '1')
            ->get();


        $ratingReview = ExpertRating::with(['seekerData'])->where('expert_id', Auth::user()->id)->get();

        $ratingData = DB::table('expert_rating')->where('expert_id', Auth::user()->id)->get();

        $i = 0;
        $m = 0;
        foreach ($ratingData as $rate) {
            $i += $rate->rating;
            $m++;
        }
        if ($i > 0) {
            $averageRating = $i / $m;
        } else {
            $averageRating = 0;
        }

        $averageRating = round($averageRating);
        if ($m > 0) {
            $totalReview = $m;
        } else {
            $totalReview = 0;
        }
        //dd(Carbon::now());
        $question30Day = DB::table('conversation_on_questions')
            ->where('user_id', Auth::user()->id)
            ->where('created_at', '<=', "'$next_due_date'")
            ->get();

        $conversations = [];
        $conversationsData = DB::table('conversation_on_questions')
            ->where('expert_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();

        $i = 0;
        foreach ($conversationsData as $conv) {
            $conversations[$i] = Chat::conversations()->getById($conv->conversation_id);
            $questionData = UserProfile::with(['seekersData'])
                ->where('id', $conv->question_id)

                ->first();
            $conversations[$i]['questionData'] = $questionData;
            $i++;
        }
        // $user_data = UserProfile::with(['seekersData'])->where('expert_id', Auth::user()->id)
        //     ->get();
        //return view('user.dashboard.dashboard_view')->with('user_data', $user_data);
        //dd($question_data);
        return view('user.dashboard.dashboard_view')->with([
            'conversations' => $conversations,
            'question30Day' => $question30Day,
            'ratingValue' => $averageRating,
            'totalReview' => $totalReview,
            'visitorNum' => $visitorNum,
            'userDetails' => $userDetails,
            'question_data' => $question_data,
            'averageTime' => $averageTime,
            'ratingReview' => $ratingReview
        ]);
    }
    public function showMessages($id)
    {
        $conversation = Chat::conversations()->getById($id);
        $data = Chat::conversation($conversation)->for(Auth::user())->getMessages();
        //dd($data);
        $getuser = DB::table('mc_conversation_user')->where('conversation_id', $id)->where('user_id', '<>', Auth::user()->id)->first();
        $get_name = User::where('id', $getuser->user_id)->first();
        $name = $get_name->first_name . " " . $get_name->last_name;
        $get_view = view('user.renders.messages_render')->with('data', $data)->render();
        $get_question = DB::table('conversation_on_questions')->where('conversation_id', $id)->first();
        $question_data = UserProfile::where('id', $get_question->question_id)->first();
        return response()->json([
            'status' => 'success',
            'messages' => $get_view,
            'name' => $name,
            'login_user' => Auth::user()->id,
            'question_data' => $question_data,
        ]);
    }
    public function transactions()
    {
        $question_data = DB::table('users_question')
            ->where('expert_id', Auth::user()->id)
            ->where('is_active', '5')
            ->where('payment_status', '1')
            ->get();
        return view('user.transaction_view')->with('question_data', $question_data);
    }
    public function settings()
    {
        $user_data = User::where('id', Auth::user()->id)->first();
        return view('user.settings_view')->with('user_data', $user_data);
    }

    public function editProfile(Request $request)
    {
        if ($request->website_url != '') {
            $website_url = $this->addhttp($request->website_url);
        } else {
            $website_url = '';
        }
        if ($request->email != '') {
            $email = $request->email;
        } else {
            $email = Auth::user()->email;
        }


        if ($request->payment_options == 'single_price') {

            $validator = Validator::make($request->all(), [
                'first_name'    => ['required', 'string', 'max:255'],
                'last_name'     => ['required', 'string', 'max:255'],
                'name'          => 'required|regex:/^[\pL\s\-]+$/u|max:255|unique:users,name,' . Auth::user()->id,
                'email'         => 'required|email|unique:users,email,' . Auth::user()->id,
                'single_price'  => 'numeric|min:1|max:250',
                'profile_photo' => 'mimes:jpg,jpeg,png|max:2000',
                'profile_bio'   => ['max:160'],
            ]);
        } else {

            $validator = Validator::make($request->all(), [
                'first_name'    => ['required', 'string', 'max:255'],
                'last_name'     => ['required', 'string', 'max:255'],
                'name'          => 'required|regex:/^[\pL\s\-]+$/u|max:255|unique:users,name,' . Auth::user()->id,
                'email'         => 'required|email|unique:users,email,' . Auth::user()->id,
                'profile_photo' => 'mimes:jpg,jpeg,png|max:2000',
                'profile_bio'   => ['max:160'],
            ]);
        }
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->hasFile('profile_photo')) {
                $profileImage = 'profile-' . time() . uniqid() . '.' . $request->profile_photo->getClientOriginalExtension();
                $request->profile_photo->move('public/uploads/user_profiles/', $profileImage);
            }

            $save_profile = User::find(Auth::user()->id);

            $save_profile->first_name   = $request->first_name;
            $save_profile->last_name    = $request->last_name;
            $save_profile->name         = $request->name;
            $save_profile->is_accept_new_questions     = $request->is_accept_new_questions;
            $save_profile->email         = $email;
            $save_profile->website_url  = $website_url;
            if ($request->payment_options != '') {
                if ($request->payment_options == 'price_Range') {
                    if ($request->price_range == 'option1') {
                        $save_profile->payment_options  = $request->payment_options;
                        $save_profile->price_range      = $request->price_range;
                        $save_profile->lower_price      = '1';
                        $save_profile->medium_price     = '3';
                        $save_profile->higher_price     = '5';
                        $save_profile->single_price     = '0';
                    } else if ($request->price_range == 'option2') {

                        $save_profile->payment_options  = $request->payment_options;
                        $save_profile->price_range      = $request->price_range;
                        $save_profile->lower_price      = '5';
                        $save_profile->medium_price     = '10';
                        $save_profile->higher_price     = '20';
                        $save_profile->single_price     = '0';
                    } else if ($request->price_range == 'option3') {

                        $save_profile->payment_options  = $request->payment_options;
                        $save_profile->price_range      = $request->price_range;
                        $save_profile->lower_price      = '10';
                        $save_profile->medium_price     = '25';
                        $save_profile->higher_price     = '50';
                        $save_profile->single_price     = '0';
                    } else if ($request->price_range == 'option4') {

                        $save_profile->payment_options  = $request->payment_options;
                        $save_profile->price_range      = $request->price_range;
                        $save_profile->lower_price      = '25';
                        $save_profile->medium_price     = '50';
                        $save_profile->higher_price     = '100';
                        $save_profile->single_price     = '0';
                    } else {

                        $save_profile->payment_options  = $request->payment_options;
                        $save_profile->price_range      = 'option1';
                        $save_profile->lower_price      = 'NULL';
                        $save_profile->medium_price     = 'NULL';
                        $save_profile->lower_price      = 'NULL';
                        $save_profile->higher_price     = 'NULL';
                    }
                } else if ($request->payment_options == 'single_price') {
                    $save_profile->payment_options  = $request->payment_options;
                    $save_profile->single_price     = $request->single_price;
                    $save_profile->price_range      = 'option1';
                    $save_profile->lower_price      = 'NULL';
                    $save_profile->medium_price     = 'NULL';
                    $save_profile->higher_price     = 'NULL';
                } else {
                    $save_profile->payment_options  = $request->payment_options;
                    $save_profile->price_range      = 'option1';
                    $save_profile->lower_price      = 'NULL';
                    $save_profile->medium_price     = 'NULL';
                    $save_profile->lower_price      = 'NULL';
                    $save_profile->higher_price     = 'NULL';
                    $save_profile->single_price     = '0';
                }
            }
            if ($request->is_newQuestionArrivedNotification) {
                $save_profile->is_newQuestionArrivedNotification  = $request->is_newQuestionArrivedNotification;
            } else {
                $save_profile->is_newQuestionArrivedNotification  = '0';
            }
            if ($request->is_reply_to_your_answer) {
                $save_profile->is_reply_to_your_answer  = $request->is_reply_to_your_answer;
            } else {
                $save_profile->is_reply_to_your_answer  = '0';
            }
            if ($request->is_expert_response_to_question) {
                $save_profile->is_expert_response_to_question  = $request->is_expert_response_to_question;
            } else {
                $save_profile->is_expert_response_to_question  = '0';
            }
            if ($request->is_marketing_messages) {
                $save_profile->is_marketing_messages  = $request->is_marketing_messages;
            } else {
                $save_profile->is_marketing_messages  = '0';
            }
            $save_profile->profile_bio  = $request->profile_bio;
            if ($request->hasFile('profile_photo')) {
                $save_profile->profile_photo  = $profileImage;
            }
            $save_profile->save();
            return back()->with(['status' => 'success', 'message' => 'Profile updated successfully.']);
        } catch (\Exception $e) {
            //return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
            return back()->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again later.']);
        }
    }
    function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }
    public function askQuestion(Request $request)
    {

        if ($request->otherAmount > 0) {
            $validator = Validator::make($request->all(), [
                'otherAmount'  => 'numeric|min:0|max:250',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }
        //try {
        if ($request->otherAmount < 1) {
            $question_worth = 0;
        } else if ($request->otherAmount > 0) {
            $question_worth = $request->otherAmount;
        } else {
            $question_worth = $request->question_worth;
        }

        if ($request->question_worth) {
            $question_worth = $request->question_worth;
        }
        //dd($question_worth);

        if ($request->email_optin) {
            $email_optin = $request->email_optin;
        } else {
            $email_optin = '0';
        }
        $questionData = UserProfile::create([
            'seeker_id' => $request->seeker_id,
            'expert_id' => $request->expert_id,
            'question_text' => $request->question_text,
            'question_worth' => $question_worth,
            'email_optin' => $email_optin,
            'is_active' => '1'
        ]);

        /* chat initialisation */
        //$check_conversation_exists = Chat::conversations()->between($request->seeker_id, $request->expert_id);
        $participants = [$request->seeker_id, $request->expert_id];
        $conversation = Chat::createConversation($participants);

        DB::table('conversation_on_questions')->insert(
            ['conversation_id' => $conversation->id, 'question_id' => $questionData->id, 'expert_id' => $request->expert_id, 'user_id' => $request->seeker_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]

        );
        DB::table('conversation_on_questions')->insert(
            ['conversation_id' => $conversation->id, 'question_id' => $questionData->id, 'seeker_id' => $request->seeker_id, 'user_id' => $request->expert_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]

        );

        // if ($check_conversation_exists == null) {
        //     //$participants = [$request->seeker_id, $request->expert_id];
        //     $conversation = Chat::createConversation($participants);
        // } else {
        //     $conversation = $check_conversation_exists;
        // }
        $message = Chat::message($request->question_text)
            ->from($request->seeker_id)
            ->to($conversation)
            ->send();

        //$user = Auth::user();
        $seekeruser = User::where('id', $request->seeker_id)->first();
        $user = User::where('id', $request->expert_id)
            ->where('is_newQuestionArrivedNotification', '=', '1')
            ->first();
        //dd($user);
        // $notificationData = [
        //     "user" => $user->first_name,
        //     "message" => " " . $seekeruser->first_name . " has ask a question :- '" . $request->question_text . "'",
        //     "seekeruser" => $seekeruser->first_name
        // ];

        // New Question Arrives
        if ($user) {
            $url = url('/my-questions');
            $notificationData = [
                "user" => $user->first_name,
                "message" => "You have a new question from " . $seekeruser->first_name . " " . $seekeruser->last_name . ".Review the question and give your throughtful answer on your account dashboard",
                "seekeruser" => $seekeruser->first_name
            ];
            $user->notify(new ExportActionOnQuestion($notificationData));
        }

        // Receive a Reply to Answer

        if ($seekeruser) {
            $notificationData = [
                "user" => $seekeruser->first_name,
                "message" => $seekeruser->first_name . " " . $seekeruser->last_name . ".has sent you a message",
                "seekeruser" => $seekeruser->first_name
            ];
            $seekeruser->notify(new SeekerActionQuestion($notificationData));
        }
        // Expert Responds to Question
        if ($user) {
            $url = url('/my-questions');
            $notificationData = [
                "user" => $user->first_name,
                "message" => "You have a new question from " . $seekeruser->first_name . " " . $seekeruser->last_name . ".Review the question and give your throughtful answer on your account dashboard",
                "seekeruser" => $seekeruser->first_name
            ];
            $user->notify(new ExportActionOnQuestion($notificationData));
        }

        return redirect('/my-questions')->with(['status' => 'success', 'message' => 'Question created successfully!']);

        return back()->with(['status' => 'success', 'message' => 'Question created successfully!']);
        // } catch (\Exception $e) {
        //     //return back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        //     return back()->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again later.']);
        // }
    }
    public function myQuestions()
    {
        $questionData = DB::table('users_question')
            ->where('is_active', 1)
            ->get();
        //dd($questionData);
        foreach ($questionData as $question) {
            $createdAt = $question->created_at;
            $arr = explode(" ", $createdAt);

            $date2date = date("Y-m-d");
            $date1 = new DateTime($arr[0]);
            $date2 = new DateTime($date2date);
            $interval = $date1->diff($date2);
            // dd($interval);
            if ($interval->days >= 7) {
                DB::table('users_question')
                    ->where('id', $question->id)
                    ->update(['is_active' => 4]);
            }
        }

        //$user_data = UserProfile::with(['seekersData'])->where('seeker_id', Auth::user()->id)->get();
        $user_data = UserProfile::with(['expertsData'])
            ->where('seeker_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();
        // $user_data = UserProfile::with(['seekersData'])->where('expert_id', Auth::user()->id)->orWhere('seeker_id', Auth::user()->id)->get();
        //dd($user_data);

        foreach ($user_data as $d) {
            $get_conv_id  = DB::table('conversation_on_questions')->where('question_id', $d['id'])->first();
            $d['conv_id'] = $get_conv_id->conversation_id;
        }
        //dd($user_data);

        return view('user.my_questions_view')->with('user_data', $user_data);
    }
    public function questionDetail($id)
    {
        $conversation  = Chat::conversations()->getById($id);
        $messages      = Chat::conversation($conversation)->for(Auth::user())->getMessages();
        $get_ques_id    = DB::table('conversation_on_questions')->where('conversation_id', $id)->first();
        $user_data = UserProfile::with(['seekersData'])->where('id', $get_ques_id->question_id)->first();
        $export_data = UserProfile::with(['expertsData'])->where('id', $get_ques_id->question_id)->first();


        return view('user.questions_details_view')->with([
            'messages' => $messages,
            'user_data' => $user_data,
            'conversation' => $get_ques_id,
            'export_data' => $export_data
        ]);
    }
    public function changePassword()
    {
        return view('user.dashboard.change_password');
    }

    public function savePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'min:8', 'same:new_password'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $user = User::find(Auth::user()->id);
            if (Hash::check($request->old_password, $user['password'])) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return back()->with(['status' => 'success', 'message' => 'Password updated successfully.']);
            }
            return back()->with(['status' => 'danger', 'message' => 'Incorrect old password.']);
        } catch (\Exception $e) {
            return back()->with(['status' => 'danger', 'message' => 'Something went wrong. Please try again later.']);
        }
    }
    public function userDecline($id)
    {
        DB::table('users_question')
            ->where('id', $id)
            ->update(['is_active' => '3']);
        return response()->json(['status' => 'success']);
    }

    public function markAsComplete(Request $request)
    {
        $question = UserProfile::find($request->ques_id);
        $question->is_active = 5;
        $question->save();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Question closed successfully!']);
    }

    public function stripeAccountCreate()
    {
        try {
            $name = Auth::user()->first_name . " " . Auth::user()->last_name;
            $email = Auth::user()->email;
            $uri = $_ENV['STRIPE_CONNECT_URL'] . $name . "&stripe_user[business_type]=individual&stripe_user[email]=" . $email;
            header("location: $uri");
            dd($uri);
        } catch (\Stripe\Error\Card $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\RateLimit $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\InvalidRequest $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\Authentication $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\ApiConnection $e) {
            return response()->json($e->getJsonBody());
        } catch (\Stripe\Error\Base $e) {
            return response()->json($e->getJsonBody());
        } catch (Exception $e) {
            return response()->json($e->getJsonBody());
        }
    }
    public function stripeUpdate()
    {
        //dd(getenv('STRIPE_SECRET'));
        $code = $_REQUEST['code'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://connect.stripe.com/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "client_secret=" . getenv('STRIPE_SECRET') . "&code=$code&grant_type=authorization_code");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        $dataSrtipe = json_decode($data);
        $stripeId = $dataSrtipe->stripe_user_id;
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['stripe_user_id' => $stripeId]);
        return redirect('/dashboard');
        header("location: $dashboard");
        $dashboard = url('/dashboard');

        return response()->json(curl_exec($ch));
    }

    public function charge(Request $request)
    {
        $token = $request->stripeToken;
        if ($token) {
            $customer = \Stripe\Customer::create(array(
                "source" => $token,
                "name" => Auth::user()->name,
                "email" => Auth::user()->email,
                "description" => Auth::user()->first_name . " " . Auth::user()->last_name
            ));

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['stripe_token' => $customer['id']]);

            return response()->json(['status' => 'success', 'message' => 'Now You are varify successfully.']);
            // return back()->with(['status' => 'success', 'message' => 'Now You are varify successfully.']);
        } else {
            // return back()->with(['status' => 'success', 'message' => 'Nooo.']);
            return response()->json(['status' => 'danger', 'message' => 'You are not varify successfully.']);
        }
    }
}
