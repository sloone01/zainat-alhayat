<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Session;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SessionController extends Controller
{
 
    
    public function searchTimetable(Request $request)
    {
        $d = date('Y-m-d',strtotime('last sunday',strtotime($request->table_date)));
        $timetable = Timetable::where([['start_date',$d],['level_id',$request->class_id]])->first();
        
        if($timetable === null ){
            $timetable = new Timetable();
            $timetable->start_date = $d;
            $timetable->level_id = $request->class_id;
            $timetable->save();
        }

        return Redirect::route('timetables',['id'=>$timetable->id]);

    }

    public function editSession(Request $request)
    {

        
        $session  = Session::find($request->session_id);
        $session->title = $request->title;
        $session->start_time = $request->start_time;
        $session->end_time = $request->end_time;
        $session->description = $request->details;
        $session->order = $request->order;
        $session->update();
    
        return Redirect::route('timetables',['id'=>$session->timetable_id]);


    }

    public function uploadFile(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',  // Customize validation as per your requirements
        // ]);

        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            // Get the file from the request
            $file = $request->file('file');

            // Get the file's original name
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store the file in the 'uploads' directory in the storage folder
           $path = $file->storeAs('uploads', $filename, 'public');  // 'public' is the disk in the config/filesystems.php
           $up = new FileUpload();
           $up->path = $path;
           $up->description = $request->desc;
           $up->session_id = $request->session_id;
           $up->save();
            // Return success response
            return back()->with('success', 'File uploaded successfully')->with('path', $path);
        }

        // Return error response if no file is uploaded
        return back()->with('error', 'No file selected');
    
    }

    public function addSession(Request $request)
    {

        
        $session  = new Session();
        $session->title = $request->title;
        $session->description = $request->details;
        $session->start_time = $request->start_time;
        $session->end_time = $request->end_time;
        $session->order = $request->order;
        $session->status = 'Active';
        $session->day = $request->day;
        $session->timetable_id = $request->timetable;
        $session->save();
    
        return Redirect::route('timetables',['id'=>$request->timetable]);


    }

}
