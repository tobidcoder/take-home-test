<?php

namespace App\Http\Controllers;

use App\Subscriber;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    //
    public function createASubscription(Request $request, $topic)
    {
        $input = $request->all();
        $validate = Validator::make($input,
            [
                'url' => 'required|url',
            ]);

        if ($validate->fails()) {
            return $this->sendError('Validation Error', $validate->errors());
        }

        //check if topic exist
        $topi = Topic::where('name', $topic)->first();
        if (empty($topi)) {
            $topi = new Topic();
            $topi->name = $topic;
            $topi->save();
        }

        //check is subscriber exist
        $user = User::where('url', $request->url)->first();

        if (empty($user)) {
            $user = new User();
            $user->url = $request->url;
            $user->save();
        }

        //check if user have subscribe to this topic before

        $check_if_subscibe_before = Subscriber::where('user_id', '=', $user->id)->where('topic_id', '=', $topi->id)->first();

        if(empty($check_if_subscibe_before)){
            $new_sub = new Subscriber();
            $new_sub->user_id = $user->id;
            $new_sub->topic_id = $topi->id;
            $new_sub->save();
        }
         return $data = [
             'url' => $request->url,
             'topic' => $topic,
         ];

    }
}
