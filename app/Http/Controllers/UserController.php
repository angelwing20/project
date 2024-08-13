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
    public function register(Request $request){
        $users=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>'required|confirmed|min:6'
        ]);
        $users['verify_code']=rand(100000,999999);
        $users['password']=bcrypt($users['password']);
        $user=User::create($users);
        Auth::login($user);
        Mail::to($user->email)->send(new UserMail($user));
        return redirect()->route('verifypage')->with('message','Register Success!');
    }

    public function verify(Request $request){
        $condition=User::where('email','=',Auth::user()->email);
        $data=$condition->get();
        if ($data[0]->verify_code==$request['verify_code']) {
            $condition->update(array('verify_time'=>'1'));
            return redirect()->route('loginpage');
        }else{
            return back()->with('message','Verify Failed!');
        }
    }

    public function login(Request $request){
        $users=$request->validate([
            'email'=>['required','email'],
            'password'=>['required','min:6']
        ]);
        if (Auth::attempt($users)) {
            $request->session()->regenerate();
            if (Auth::user()->verify_time==='1') {
                return redirect()->route('main')->with('message','Login Success!');
            }else{
                return redirect()->route('verifypage')->with('message','Please verify account!');
            }
        }else{
            return redirect()->route('loginpage')->with('message','Wrong Email or Password!');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('main')->with('message','Logout Success!');
    }
}