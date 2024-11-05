<?php

namespace App\Providers;


use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GeneralHelper
{

    public static function getNotification()
    {
        $var = Notification::where('user_id', '=', Auth::user()->id)
            ->orderBy('id','DESC')->limit(5)->get()->toArray();
        return array_map(fn($u)=>array('date'=>$u['created_at'],
            'title'=> MessageConstants::messages[$u['message_id']]
        ),$var);

    }
    public static function getAdmins($dep)
    {
        return User::where([['roles','like', '%Admin%']])->get();
    }
}

