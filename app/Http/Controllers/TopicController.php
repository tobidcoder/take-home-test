<?php

namespace App\Http\Controllers;

use App\Events\Subscribers;
use App\Subscriber;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    //

    public function publishMessageToTopic(Request $request, $topic){
         $validate = Validator::make($request->all(), [
                'message' => 'required',
            ]);


            if ($validate->fails()) {
                return $this->sendError('Validation Error', $validate->errors());
            }

        //check if topic exist
        $topics = new Topic();
        $topi = $topics->where('name', $topic)->first();
        if (empty($topi)) {
            $topics->name = $topic;
            $topics->save();
        }

        event(new Subscribers($request->all(),$topic));

        return [
                'topic' => $topic,
                'data' => $request->all(),
               ];
    }

    public function returnSubscription($any){
//        return url("/$any");
        $user = User::where('url',url("/$any"))->first();

        if(empty($user)){
            return $this->sendError('Subscriber not exit');
        }
        $subscriber = Subscriber::where('user_id',$user->id)->first();

        if(empty($subscriber)){
            return view('welcome')->with('topic', '');
        }

        $topic = Topic::find($subscriber->topic_id);

        return view('welcome')->with('topic', $topic->name);
    }
}