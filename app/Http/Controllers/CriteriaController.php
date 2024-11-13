<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Level;
use App\Models\Performance;
use App\Models\planet;
use App\Models\Reading;
use App\Models\User;
use App\Models\WorkLog;
use Dotenv\Store\File\Reader;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CriteriaController extends Controller
{
    public function activatePlanet($dept_id)
    {
        $dept =  Criteria::find($dept_id);
        $dept->status = $dept->status == 'ACT' ? 'INC' : 'ACT';
        $dept->save();
        $all = Criteria::all();
        return Redirect::route('criterias')->with([
            'message' => 'Status Changed Successfully',
            'criterias' => $all
        ]);
    }
    public function deletePlanet($dept_id)
    {
        if (
            Performance::where('criteria_id', $dept_id)->count() > 0 
        )
            return back()->with('error', 'Planet already Used');

        Criteria::find($dept_id)->delete();
        return Redirect::route('criterias')->with([
            'message' => 'Planet Deleted Successfully',
            'criterias' => Criteria::all()
        ]);
    }
    public function saveEditCri(Request $request)
    {
        $planet  = Criteria::find($request->cri_id);

        $planet->name = $request->name;
        $planet->classes = implode(',', $request->levels);

        $planet->save();
        return Redirect::route('criterias')->with([
            'message' => 'Planet Updated Successfully',
            'criterias' => Criteria::all()
        ]);
    }
    public function saveCriteria(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:criterias',
        ], [
            'name.required' => 'Criteria name is Required',
            'name.unique' => 'Criteria name Already Exist'
        ]);

        $planet  = new Criteria();
        $planet->name = $request->name;
        $planet->type = $request->cri_type;
        $planet->version = 1;
        $planet->classes = implode(',', $request->levels);
        $planet->save();

        return Redirect::route('criterias')->with([
            'message' => 'Criteria Added Successfully',
            'criterias' => Criteria::all()
        ]);
    }

    public function changeStatus(Request $request)
    {
        $record = Performance::where([['criteria_id',$request->criteria_id],
         ['child_id',$request->child_id],['status','N']])->update(['status'=>'ND']);
         
         dd($record);
        $stu = User::find($request->child_id);

        $students = User::where([['roles', 'Student'], ['level_id', $stu->level_id]])->get();
        $criterias = Criteria::whereRaw('FIND_IN_SET(?, classes)', [$stu->level_id])->get();

        

        $mapped = $students->map(function ($student) use ($criterias, $stu) {
            $performanceData = [];
            foreach ($criterias as $c) {
                $performanceData[$c->name] = Performance::where([['criteria_id', $c->id], ['child_id', $student->id],['status','<>','Y']])->first();
            }
            return [
                'id' => $student->id,
                'name' => $student->name,
                'class' => $student->name,
                'class_id' => $stu->level_id,
            ] + $performanceData;
        });


        return Redirect::route('student-list',['id'=>$stu->level_id])->with(
            [
                'worklogs' => $mapped,
                'classes' => Level::all(),
                'class_id' => $stu->level_id,
                'criterias' => $criterias,
            ]
            );
    }
    public function savePerformance(Request $request)
    {

        Performance::where([['criteria_id',$request->criteria_id],
         ['child_id',$request->child_id],['status','N']])->update(['status'=>'Y']);
         
        $stu = User::find($request->child_id);
        $planet  = new Performance();
        $planet->title = $request->title;
        $planet->start_date = $request->end_date;
        $planet->child_id = $request->child_id;
        $planet->criteria_id = $request->criteria_id;
        $planet->created_by = Auth::user()->id;
        $planet->save();

        $level = Level::find($request->class_id);
        $students = User::where([['roles', 'Student'], ['level_id', $stu->level_id]])->get();
        $criterias = Criteria::whereRaw('FIND_IN_SET(?, classes)', [$stu->level_id])->get();

        

        $mapped = $students->map(function ($student) use ($criterias, $stu) {
            $performanceData = [];
            foreach ($criterias as $c) {
                $performanceData[$c->name] = Performance::where([['criteria_id', $c->id], ['child_id', $student->id],['status','<>','Y']])->first();
            }
            return [
                'id' => $student->id,
                'name' => $student->name,
                'class' => $student->name,
                'class_id' => $stu->level_id,
            ] + $performanceData;
        });


        // return view('childs.childs-performance', [
        //     'worklogs' => $mapped,
        //     'classes' => Level::all(),
        //     'class_id' => $stu->level_id,
        //     'criterias' => $criterias,
        // ]);

        return Redirect::route('student-list',['id'=>$stu->level_id])->with(
            [
                'worklogs' => $mapped,
                'classes' => Level::all(),
                'class_id' => $stu->level_id,
                'criterias' => $criterias,
            ]
            );


    }
    public function addReading(Request $request)
    {

        Reading::where([['child_id',$request->child_id],
         ['status','N']])->update(['status'=>'Y']);

         $sups = User::where([['roles','Supervisor']])->get();
         
        $stu = User::find($request->child_id);
        $planet  = new Reading();
        $planet->title = $request->title;
        $planet->start_date = $request->start_date;
        $planet->end_date = $request->end_date;
        $planet->child_id = $request->child_id;
        $planet->supervisor_id = $request->sup;
        $planet->created_by = Auth::user()->id;
        $planet->save();


        $students = User::leftJoin('readings', function($join) {
            $join->on('users.id', '=', 'readings.child_id')
            ->where('readings.status', '=', 'N');
          })->where([['users.roles','Student']])
          ->select('users.id as user_id','users.*', 'readings.*')
          ->get();
        
        
    

        return Redirect::route('reading-list',['l'=>$request->sup])->with(
            [
                'sups'=> $sups,
                'sup_id'=>$request->sup
            ]
            );


    }
}
