<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\HelloMail;
use Illuminate\Support\Facades\Mail;


class AuthManager extends Controller
{
    function login(){
        if(Auth::check()){
            return redirect(route('home'));
        }
        return view('login');
    }

    function registration(){
        return view('registration');
    }

    function loginPost(Request $request){
        error_log('login post');
        $credentials = $request->only('email','password');
        if(Auth::attempt($credentials)){
            error_log('login post Done');
            return redirect()->intended(route('home'));
        }
        error_log('login post failed');
        return redirect(route('login'))->with('error',"login details are invalid!!");

    }

    function registrationPost(Request $request){
        $request->validate([
            'full_name'=>'required',
            'user_name'=>'required',
            'birthdate'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'password'=>'required',
            'email'=>'required'
        ]);

        $data['full_name'] = $request->full_name;
        $data['user_name'] = $request->user_name;
        $data['birthdate'] = $request->birthdate;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['password'] = Hash::make($request->password);
        $data['email'] = $request->email;

        $user = User::create($data);

        if(!$user){
            return redirect(route('registration'))->with('error','Registration failed!!');
        }
        Mail::to($request->email)->send(new HelloMail($request->email,$request->user_name));
        return redirect(route('login'))->with('success','Registration Success, Login to access your app!!');
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}
