<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\UserProfileView;
use App\Notifications\WelcomeToTransitPro;
use Illuminate\Http\Request;

use App\Models\User;

use Notification;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DB;


class UserController extends Controller
{
    function create(Request $request){
          //Validate Inputs
          $request->validate([
              'first_name'=>'required',
              'email'=>'required|email|unique:users,email',
              'password'=>'required|min:5|max:30',
              'cpassword'=>'required|min:5|max:30|same:password'
          ]);

        $admin = new User();
        $admin->first_name=$request->first_name;
        $admin->last_name=$request->last_name;
        $admin->email=$request->email;
        $admin->gender=$request->gender;
        $admin->contact_no=$request->contact_no;
        $admin->district=$request->district;
        $admin->ward_no=$request->ward_no;
        $admin->thana=$request->thana;
        $admin->house_no=$request->house_no;
        $admin->password=Hash::make($request->password);
        $save=$admin->save();

          if( $save ){
              $user=DB::select("select * from users where id= $admin->id");


              return redirect()->back()->with('success','You are now registered successfully .Check Your Mail');

          }else{
              return redirect()->back()->with('fail','Something went wrong, failed to register');
          }
    }

    function check(Request $request){
        //Validate inputs
        $request->validate([
           'email'=>'required|email|exists:users,email',
           'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>'This email is not exists on users table'
        ]);

        $creds = $request->only('email','password');
        if( Auth::guard('web')->attempt($creds) ){
            return redirect()->route('user.home');
        }else{
            return redirect()->route('user.login')->with('fail','Incorrect credentials');
        }
    }

    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
    function profile(Request $request){
        $id = $request->input('id');
        $user=DB::select("select * from userprofileview where id= $id");
        $user=$user[0];
        return view('dashboard.user.profile',compact('user'));
        //dd($user);
    }


    
}
