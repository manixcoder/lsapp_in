<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Auth;
use Musonza\Chat\Models\ConversationUser;
use Musonza\Chat\Models\MessageNotification;
use App\Models\UserProfile;
use Notification;
use App\Notifications\Export\ExportActionOnQuestion;
use App\Notifications\Seeker\SeekerActionQuestion;
use Chat;
use DB;

class ChatController extends Controller
{
    public function getAllConversations()
	{
        $conversations = Chat::conversations()->for(Auth::user())->get();
        //dd($conversations);

		foreach($conversations as $conv)
		{	
			$user = ConversationUser::where('user_id', '<>', Auth::user()->id)->where('conversation_id', $conv['id'])->first();

			//$user_data = User::with(['getRole'])->where('id', $user['user_id'])->first();

			$conv['user'] = $user_data;

			/* Get unread message count */
			$count = Chat::conversation($conv)->for(Auth::user())->unreadCount();

			$conv['unread_count'] = $count;
		}
		
		$users = User::with(['getRole'])->whereHas('roles', function($q){
        			$q->where('name', 'admin')->orWhere('name', 'shopper');
        		 })->get();

		return view('host.conversations')->with(['conversations' => $conversations, 'users' => $users]);
	}
    public function getChat($id)
    {
        $conversation = Chat::conversations()->between(Auth::user(), $id);
        if ($conversation != null) {
            $messages = Chat::conversation($conversation)->for(Auth::user())->getMessages();

            /* Check if any message is unread in conversation */
            $unread = Chat::conversation($conversation)->for(Auth::user())->unreadCount();

            if ($unread) {
                /* Mark messages as read */
                foreach ($messages as $msg) {
                    $mark_read = Chat::message($msg)->for(Auth::user())->markRead();
                }
            }
        } else {
            $messages = "";
        }

        $conv_with_user = User::with(['getRole'])->where('id', $id)->first();
        //dd($messages);

        return view('host.chat_view')->with(['messages' => $messages, 'conv_with_user' => $conv_with_user]);
    }
    public function sendMessage(Request $request)
    {
        $conversation = Chat::conversations()->getById($request->conv_id);
        $message = Chat::message($request->message)
            ->from(Auth::user())
            ->to($conversation)
            ->send();


        $data = Chat::conversation($conversation)->for(Auth::user())->getMessages();
        //dd($data);

        $get_view = view('user.renders.messages_render')->with('data', $data)->render();

        return response()->json(['status' => 'success', 'messages' => $get_view]);
    }

    public function acceptQuestion(Request $request)
    {
        $conversation = Chat::conversations()->getById($request->conv_id);
        $message = Chat::message($request->message)
            ->from(Auth::user())
            ->to($conversation)
            ->send();


        $data = Chat::conversation($conversation)->for(Auth::user())->getMessages();

        $get_view = view('user.renders.messages_render')->with('data', $data)->render();

        /* Set question as answered */
        $question = UserProfile::find($request->ques_id);
        $question->is_active = 2;
        $question->save();
        /**** Notification ***/ 
        $seekeruser = User::where('id', Auth::user()->id)->first();
        $user = User::where('id', Auth::user()->id)
            ->where('is_newQuestionArrivedNotification', '=', '1')
            ->first();
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

        return response()->json(['status' => 'success', 'messages' => $get_view]);
    }
}
