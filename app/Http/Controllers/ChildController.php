<?php

namespace App\Http\Controllers;

use App\Exports\WorkLogaExport;
use App\Mail\MailHelper;
use App\Mail\TicketEmail;
use \Illuminate\Support\Collection;
use App\Models\Comment;
use App\Models\Criteria;
use App\Models\Notification;
use App\Models\Problem;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\JobType;
use App\Models\Performance;
use App\Models\planet;
use App\Models\User;
use App\Models\WorkLog;
use App\Providers\MessageConstants;
use App\Providers\SearchHelper;
use App\Providers\NotificationHelper;
use App\Providers\RoleHelper;
use App\Providers\StatusConstants;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class ChildController extends Controller
{
private SearchHelper $searchHelper;
private $department;
private $RESOLVER='resolver';
private $CREATOR='creator';

public function __construct()
{
    $this->searchHelper  = new SearchHelper();
}

public function getOwnTickets()
{

    return DB::table('tickets')->where('created_by',Auth::user()->id)->get();
}



public function saveEdit(Request $request){

    $request->validate([
        'mwo_number'=>'required|max:50',
        'tags_no'=>'required|max:50',
        //'type_of_job'=>'required|different:Choose',
        //'observation'=>'required|max:50',
        'repairing'=>'required|max:50',
        'spare_consumed'=>'required|max:50',
        //'time_taken'=>'required|max:50',
        'job_date'=>'required|max:50',
        //'tech_ref'=>'required|max:50',
        'planet'=>'required|max:50',
        //'shift'=>'required|max:50',
    ]);



    // // $workType = JobType::find($request->type_of_job);
    // //$department = Department::find($problem->type_of_job->id);
    // // $users = User::where([['roles','like', '%Dep Admin%'], ['department_id',$department->id]])->get()->toArray();
    // try {
        $log = WorkLog::find($request->id);
        $log->created_by = Auth::user()->id;
        $log->mwo_number = $request->mwo_number;
        $log->tags_no = $request->tags_no;
        $log->repairing = $request->repairing;
        $log->spare_consumed = $request->spare_consumed;
        $log->job_date = $request->job_date;
        //$log->shift_id = 1;//$request->shift;
        if($request->input('action') == "change_status")
        {
            $log->status = "submitted";
        }
        $log->save();


        $query = WorkLog::where('created_by',Auth::user()->id)
        ->orWhere('tech_ref',Auth::user()->id)
        ->orWhere(function ($q){
            $planet_ids = planet::select('id')->where('id','=',Auth::user()->planet_id)->get();
            $q->when(RoleHelper::isEngineer(),function ($q) use ($planet_ids){
                return $q->whereIn('planet_id',$planet_ids);
            });
        });
    return view('childs.childs-performance',
    ['worklogs'=> $query->get(),
    'techs'=> User::where('roles','=','tech')->get(),
    'message'=> 'record Updated succefully',
    'planets'=> planet::where([['status','=','ACT'],['isMain',false]])->get(),
    'types'=> JobType::where('status','=','ACT')->get()
]);
}
public function saveLog(Request $request){

    
    $request->validate([
        'mwo_number'=>'required|max:50',
        'tags_no'=>'required|max:50',
        //'type_of_job'=>'required|different:Choose',
        //'observation'=>'required|max:50',
        'repairing'=>'required|max:50',
        'spare_consumed'=>'required|max:50',
        //'time_taken'=>'required|max:50',
        'job_date'=>'required|max:50',
        //'tech_ref'=>'required|max:50',
        //'planet'=>'required|max:50',
        //'shift'=>'required|max:50',
    ]);

    // // $workType = JobType::find($request->type_of_job);
    // //$department = Department::find($problem->type_of_job->id);
    // // $users = User::where([['roles','like', '%Dep Admin%'], ['department_id',$department->id]])->get()->toArray();
    // try {
        $log = new WorkLog();
        $log->created_by = Auth::user()->id;
        $log->mwo_number = $request->mwo_number;
        $log->planet_id= $request->planet;
        $log->tags_no = $request->tags_no;
        $log->type_of_job = 1;//$request->type_of_job;
        $log->observation = '';//$request->observation;
        $log->repairing = $request->repairing;
        $log->spare_consumed = $request->spare_consumed;
        $log->time_taken = 0;//$request->time_taken;
        $log->job_date = $request->job_date;
        $log->tech_ref = Auth::user()->id;
        $log->shift_id = 1;//$request->shift;
        $log->save();

        $query = WorkLog::where('created_by',Auth::user()->id)
        ->orWhere('tech_ref',Auth::user()->id)
        ->orWhere(function ($q){
            $planet_ids = planet::select('id')->where('id','=',Auth::user()->planet_id)->get();
            $q->when(RoleHelper::isEngineer(),function ($q) use ($planet_ids){
                return $q->whereIn('planet_id',$planet_ids);
            });
        });
    return view('childs.childs-performance',['worklogs'=> $query->get(),
    'techs'=> User::where('roles','=','tech')->get(),
    'message'=> 'record saved succefully',
    'planets'=> planet::where([['status','=','ACT'],['isMain',false]])->get(),
    'types'=> JobType::where('status','=','ACT')->get()
]);


        // $users1 = array_map(fn($u) => array($u['email']), $users);
        // MailHelper::EmailMany(MailHelper::ticket_created_subject,
        // MailHelper::ticket_created_message,$log,$users1);



        // $note = new Notification();
        // $note->ref_id = $log->id;
        // $note->message_id = (new MessageConstants())::ticket_opened;
        // $note->module_name = 'tickets';
        // $this->searchHelper->NotifyDepAdmin($note,$department);


    // }catch (Exception $e)
    // {

    // }



}
public function export($logs) 
{
   return Excel::download(new WorkLogaExport($logs), 'worklogs.xlsx');
}
public function adminSearch(Request $request){

    $query = WorkLog::query();
    $this->searchHelper->prepareStatusQuery($query,$request->status,$request);

    $logs = $query->get();
    
    if($request->input('action') == "print")
    {
    return $this->export($logs);
    }
    

    return view('childs.childs-performance',['worklogs'=> $logs,
    'techs'=> User::where('roles','=','tech')->get(),
    'planets'=> planet::where([['status','=','ACT'],['isMain',false]])->get(),
    'types'=> JobType::where('status','=','ACT')->get(),
    'filters'=>$this->searchHelper->getfiltersArray($request)
]);

    // return Redirect::route('user-logs')->with(['logs'=>$logs,,
    //         'departments'=>Department::all(),'problems'=> Problem::all()]);
}
public function depAdminSearch(Request $request){

    $query = WorkLog::query();
    $this->searchHelper->prepareStatusQuery($query,$request->status,$request);
    $query->where('Assigned_department',Auth::user()->department_id);
    $tickets = $query->get();
    return Redirect::route('logs-dep-list')->with(
        ['tickets'=>$tickets,'filters'=>$this->searchHelper->getfiltersArray($request),
        'problems'=> Problem::all()]);
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
    $note->module_name = 'work logs';
    $workLog = User::find($request->id);
    $notify = '';


    //  MailHelper::SendTicketInteractionEmail(
    //      MessageConstants::messages[$note->message_id],
    //      $workLog,
    //      $notify);


    $comment->save();
    $this->searchHelper->NotifyMany($note,$workLog);
    return view('childs.single-student',['log'=>User::find($request->id)]);
}

public function answerQuery(Request $request){
   $user = User::find($request->workLog);

    $note = new Notification();
    $note->ref_id = $user->id;
    $note->module_name = 'Users';
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
    $user = User::find($workLog->id);
    

    //$this->searchHelper->NotifyMany($note,$user);
    // MailHelper::SendTicketEmail($subject, $message,$ticket,$email);



    return view('childs.single-student',['log'=>$user,
        'cri'=> Criteria::whereRaw('FIND_IN_SET(?, classes)', [$user->level_id])->get(),
        'performance'=>Performance::where([['child_id',$user->id]])->get()]);


}
function isAnswerd($com): bool
{
    return $com['query_status'] != 'Answered';
}
}
