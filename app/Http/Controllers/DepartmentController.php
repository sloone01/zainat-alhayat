<?php

namespace App\Http\Controllers;

use App\Mail\Ticket;
use App\Models\Department;
use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class departmentController extends Controller
{

    public function activateDep($dept_id){
        $dept = Department::find($dept_id);
        $dept->status=$dept->status == 'ACT' ? 'INC' : 'ACT';
        $dept->save();
        $all = Department::all();
        return Redirect::route('departments')->with([
            'message'=> 'Status Changed Successfully',
            'departments'=> $all]);

    }
    public function deleteDept($dept_id)
    {
        if(User::where('department_id',$dept_id)->count() > 0 ||
           Problem::where('resp_department',$dept_id)->count()> 0 ||
           Ticket::where('Assigned_department',$dept_id)->count()> 0 )
            return back()->with('error','Department already Used');

        Department::find($dept_id)->delete();
        return Redirect::route('departments',[
            'message'=> 'Department Deleted Successfully',
            'departments'=> Department::all()]);

    }
    public function editDepDetails(Request $request){
        $department = planet::find($request->id);
        $department->name = $request->name;
        $department->save();
        return Redirect::route('departments')->with([
            'message'=> 'Department Updated Successfully',
            'departments'=>Department::all()]);
    }
    public function saveDepartment(Request $request){
        $request->validate([
            'name'=> 'required|unique:planets',
        ],[
            'name.required'=> 'Planet name is Required',
            'name.unique'=> 'Planet name Already Exist'
        ]);

        $department = new P();
        $department->name = $request->name;
        $department->save();

        return Redirect::route('departments')->with([
            'message'=> 'Department Added Successfully',
            'departments'=>Department::all()]);

    }
}
