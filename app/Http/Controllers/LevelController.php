<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobType;
use App\Models\Level;
use App\Models\Problem;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WorkLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LevelController extends Controller
{

    public function changeStatus($dept_id){
        $dept = Level::find($dept_id);
        $dept->status=$dept->status == 'ACT' ? 'INC' : 'ACT';
        $dept->save();
        $all = Level::all();
        return Redirect::route('classes')->with(
            ['message'=> 'Status Changed Successfully',
            'classes'=> $all]);

    }

    public function getProblemById(Request $request)
    {

    }
    public function deleteJob($pro)
    {
        if(WorkLog::where('type_of_job',$pro)->count() > 0)
            return back()->with('error','Job Type already Used');

        JobType::find($pro)->delete();
        $all = JobType::all();
        return Redirect::route('classes')->with(
            ['message'=> 'deleted Successfully',
            'classes'=> $all]);

    }

    public function saveClass(Request $request){

        $request->validate([
            'title'=> 'required|unique:levels',
        ]);

        $JobType = new Level();
        $JobType->title = $request->title;
        $JobType->save();

        return view('classes.classes-list',['message'=> 'Class Added Successfully',
            'classes'=> Level::all()]);
    }

    public function saveEditClass(Request $request){

        $request->validate([
            'title'=> 'required|max:255',
        ]);

        $JobType = Level::find($request->id);
        $JobType->title = $request->title;
        $JobType->save();

        return view('classes.classes-list',['message'=> 'Class Updated Successfully',
            'classes'=> Level::all()]);
    }

}
