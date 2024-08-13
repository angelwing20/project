<?php

namespace App\Http\Controllers;

use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function main(){
        return view('main');
    }
    public function registerpage(){
        return view('register');
    }
    public function register(Request $request){
        $users=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>'required|confirmed|min:6'
        ]);
        $users['verify_code']=rand(100000,999999);
        $users['password']=bcrypt($users['password']);
        $user=User::create($users);
        Mail::to($user->email)->send(new UserMail($user));
        Auth::login($user);
        return redirect('/verify')->with('message','Register Success!');
    }

    public function loginpage(){
        return view('login');
    }

    public function login(Request $request){
        $users=$request->validate([
            'email'=>['required','email'],
            'password'=>['required','min:6']
        ]);
        if (Auth::attemp($users)) {
            $request->session()->regenerate();
            if (Auth::user()->verify_time==='1') {
                return redirect('/main')->with('message','Login Success!');
            }else{
                return back()->with('Login Failed!');
            }
        }
    }
}
