<?php

namespace App\Providers;




use App\Models\Notification;
use App\Models\User;
use App\Models\planet;
use App\Models\WorkLog;
use DateTime;
use Illuminate\Support\Facades\Auth;

class SearchHelper
{

    public function NotifyAdmin(Notification $notification){
        $users = User::where('roles','like', '%Admin%')->get();
        $this->AddForEachUser($users,$notification);
    }
    public function NotifyDepAdmin(Notification $notification,$dep){
        $users = User::where([['roles','like', '%Dep Admin%'],
            ['department_id',$dep->id]])->get();
        $this->AddForEachUser($users,$notification);
    }
    public function NotifyResolvers(Notification $notification,$user_id){
        $this->AddForSingle($user_id,$notification);
    }
    public function NotifyMany(Notification $notification,$worklog)
    {
        $this->AddForSingle(1,$notification);
        $this->AddForSingle(1,$notification);

    }

    private function AddForSingle($user,$notification){
            $not = New Notification();
            $not->ref_id = $notification->ref_id;
            $not->message_id = $notification->message_id;
            $not->module_name = $notification->module_name;
            $not->user_id = $user;
            $not->save();
    }

    private function AddForEachUser($users,$notification){
        foreach ($users as $user)
        {
            $not = New Notification();
            $not->ref_id = $notification->ref_id;
            $not->message_id = $notification->message_id;
            $not->module_name = $notification->module_name;
            $not->user_id = $user->id;
            $not->save();
        }
    }


    public static array $statusFilter = array(
        'Status'=>array(
            'New'=>'Completed',
            'Submitted'=>'Not Completed'),
        
        );
    public function prepareStatusQuery($query,$status,$request){
        $status = $request->status;
    
        $dates = [$request->job_date_f,$request->job_date_to];
        $key = $request->key;
        $planets = $request->planets;
        $techs = $request->techs;
        $jobTypes = $request->jobTypes;

        $query->when($request->status,function ($q) use ($status){
            return $q->whereIn('status',$status);
        });

        $query->when($request->job_date_f && $request->job_date_to,function ($q) use ($dates){
            return $q->whereBetween('job_date',$dates);
        });
        $query->when($key,function ($q) use ($key){
            return $q->where('mwo_number','LIKE','%'.$key.'%')
            ->orWhere('repairing','LIKE','%'.$key.'%')
            ->orWhere('observation','LIKE','%'.$key.'%')
            ->orWhere('equip_no','LIKE','%'.$key.'%');
        });

        $query = $query->when($request->planets,function ($q) use ($planets){
            return $q->whereIn('planet_id',$planets);
        });
        $query = $query->when($request->techs,function ($q) use ($techs){
            return $q->whereIn('tech_ref',$techs);
        });
        $query = $query->when($request->jobTypes,function ($q) use ($jobTypes){
            return $q->whereIn('type_of_job',$jobTypes);
        });

        $query->where('created_by',Auth::user()->id)
        ->orWhere('tech_ref',Auth::user()->id)
        ->orWhere(function ($q){
            $planet_ids = planet::select('id')->where('id','=',Auth::user()->planet_id)->get();
            $q->when(RoleHelper::isEngineer(),function ($q) use ($planet_ids){
                return $q->whereIn('planet_id',$planet_ids);
            });
        });
        return $query;
    }
    public function getStatusType($status){

        if ($status == null)
            return array();
        $func = function (string $val) : array {
            $split =explode("-", $val);;
            return array($split[1]=>$split[0]);
        };

        $res = array_values(array_map($func,$status));
        return array_reduce($res,function ($result, $item){
            $result[array_keys($item)[0]] = array_values($item)[0];
            return $result;
        });

    }
    public function getfiltersArray($request)
    {
        $filters = array();
        $filters['techs'] = $request->techs ?:  array();
        $filters['planets'] = $request->planets ?:  array();
        $filters['status'] = $request->status ?:  array();
        $filters['title'] = $request->title ?:  '';
        $filters['jobTypes'] = $request->jobTypes ?:  array();
        $filters['key'] = $request->key ?:  '';
        $filters['create_date'] = $request->create_date ?:  '';
        $filters['job_date_f'] = $request->job_date_f ?:  '';
        $filters['job_date_to'] = $request->job_date_to ?:  '';
        
        return $filters;

    }
}
