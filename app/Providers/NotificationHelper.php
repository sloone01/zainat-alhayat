<?php

use \App\Models\Notification;
use \App\Models\User;
use App\Providers\MessageConstants;

class  NotificationHelper{
    public function  NotifyAdmin(Notification $notification){
        $users = User::where('role','like', '%Admin%');
        $notes  = array_map(function ($u) use ($notification) {
            $not  = clone  $notification;
            $not->user_id = $u->id;
            $note = new Notification();
            $note->ref_id = $ticket->id;
            $note->message_id = (new MessageConstants())::ticket_opened;
            $note->module_name = 'tickets';
            $not->save();
        },$users);
}

}
