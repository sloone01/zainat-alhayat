<?php

namespace App\Http\Controllers;

use App\Mail\MailHelper;
use App\Mail\Subscribe;
use App\Mail\TicketEmail;
use App\Models\Department;
use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    private $str;

    public function saveUser(Request $request)
    {
        $this->str = 'Email Address Already Linked to user';
        $request->validate([
            'email'=>'required|unique:users',
            'name'=>'required|max:50',
            'planet'=>'required|different:Choose',
        ],[
            'email.unique'=> $this->str
        ]);
        $pass = $this->generateRandomString();
        $user = new User();
        $user->name = $request->name;
        $user->level_id = $request->planet;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($pass);
        $user->roles = implode(',',$request->roles);
        $user->save();

        $user->password = $pass;

        // MailHelper::SendUserEmail(MailHelper::registered_subject,
        // MailHelper::login_credentials_message,$user,$request->email);

        return Redirect::route('users-list')->with([
            'message'=> 'User Added Successfully',
            'users'=> User::all()]);
    }
    public function update_user(Request $request)
    {
        $id = $request->id;

        $request->validate([
            'name'=>'required|max:50'
        ]);
        if(User::where([['email','=',$request->email],['id','!=', $id]])->count() > 0)
        {
            $user = new User();
            $user->id = $id;
            $user->name = $request->name;
            $user->planet_id = $request->planet_id;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->roles = implode(',',$request->roles);
            return view('User.edit-user',['user'=> $user,
                'roles'=> explode(",",$user->roles),
                'error'=> 'Email Already Used',
                'departments'=> Department::where('status','=','ACT')->get()]);
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->roles = implode(',',$request->roles);
        $user->save();

        return Redirect::route('users-list')->with([
            'message'=> 'User Updated Successfully',
            'users'=> User::all()]);
    }


    public function disableUser($user_id){
        $user = User::find($user_id);
        $user->IsActive = !$user->IsActive;
        $user->save();
        return Redirect::route('users-list')->with([
            'message'=> 'Status Changed Successfully',
            'users'=> User::all()]);
    }


    public function resetPassword($user_id){
        $user = User::find($user_id);
        $pass = $this->generateRandomString();
        $user->first_login = 1;
        $user->password = Hash::make($pass);
        $user->save();

        $user->password = $pass;

        MailHelper::SendUserEmail(MailHelper::reset_pass_subject,
            MailHelper::login_credentials_message,$user,$user->email);

        return Redirect::route('users-list')->with([
            'message'=> 'Password Reset Is Sent',
            'users'=> User::all()]);
    }

    public function login(Request $request)
    {
        $cre = $request->only('email','password');
        if(Auth::attempt($cre)){
            $user = User::find(Auth::user()->id);
            if(!$user->is_active)
                return back()->with('error','User is Not Active');
            if($user->first_login == 1){
                return Redirect::route('user-reset-page');
            }
            return redirect()->route('student-list',['l'=>1]);
        }

        return back()->with('error','Wrong Credential');
    }

    public function reset_pass(Request $request){
        $pass1 = $request->pass1;
        if($pass1 != $request->pass2)
            return back()->with('error','password should be match');

        $user = User::find(Auth::user()->id);
        $user->password= Hash::make($pass1);
        $user->first_login = 0;
        $user->save();
        Auth::logout();
        return Redirect::route('user-login');

    }

    function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
