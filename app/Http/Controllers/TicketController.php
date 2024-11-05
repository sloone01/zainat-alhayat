<?php

namespace App\Http\Controllers;

use App\Mail\MailHelper;
use App\Mail\TicketEmail;
use \Illuminate\Support\Collection;
use App\Models\Comment;
use App\Models\Criteria;
use App\Models\Notification;
use App\Models\Problem;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Performance;
use App\Models\User;
use App\Models\WorkLog;
use App\Providers\MessageConstants;
use App\Providers\SearchHelper;
use App\Providers\NotificationHelper;
use App\Providers\StatusConstants;
use Carbon\Exceptions\Exception as ExceptionsException;
use Exception as GlobalException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;



use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class TicketController extends Controller
{
   private SearchHelper $searchHelper;

    public function __construct()
    {
        $this->searchHelper  = new SearchHelper();
    }

    public function addComment(Request $request){
        $request->validate(['comment'=>'required|min:3']);
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->child_id=$request->id;

        $note = new Notification();
        $note->ref_id = $request->id;
        $note->message_id = (new MessageConstants())::log_commented;;
        $note->module_name = 'Students';
        $user = User::find($request->id);
        $notify = '';
   

        //  MailHelper::SendTicketInteractionEmail(
        //      MessageConstants::messages[$note->message_id],
        //      $workLog,
        //      $notify);


        $comment->save();
        $this->searchHelper->NotifyMany($note,$user);
        return view('childs.single-student',['log'=>$user,
        'cri'=> Criteria::whereRaw('FIND_IN_SET(?, classes)', [$user->level_id])->get(),
        'performance'=>Performance::where([['child_id',$user->id]])->get()]);
    }

    public function answerQuery(Request $request){
       $user = User::find($request->workLog);

        $note = new Notification();
        $note->ref_id = $user->id;
        $note->module_name = 'work logs';
        $note->message_id = (new MessageConstants())::comment_reply;
    
       $comment = Comment::find($request->comment_id);
    //    $comment->query_status = 'Answered';
       $answer = new Comment();
    //    $answer->type='Answer';
       $answer->comment_id=$comment->id;
       $answer->user_id = Auth::user()->id;
       $answer->comment = $request->answer;


        $answer->save();
        $comment->save();
        $user = User::find($user->id);
        

        //$this->searchHelper->NotifyMany($note,$workLog);
        // MailHelper::SendTicketEmail($subject, $message,$ticket,$email);


 
        $this->searchHelper->NotifyMany($note,$user);
        return view('childs.single-student',['log'=>$user,
        'cri'=> Criteria::whereRaw('FIND_IN_SET(?, classes)', [$user->level_id])->get(),
        'performance'=>Performance::where([['child_id',$user->id]])->get()]);

    }
    function isAnswerd($com): bool
    {
        return $com['query_status'] != 'Answered';
    }
}
