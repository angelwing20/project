<?php

namespace App\Http\Controllers;

use App\Mail\UserMail;
use App\Models\User;
use App\Models\products;
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

    public function edituser(Request $request,User $id){
        $edit=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email'],
            'ic_number'=>'nullable',
            'gender'=>'nullable',
        ]);
        if ($request->email !== $id['email']) {
            $id['verify_code']=rand(100000,999999);
            $id['verify_time']=Null;
        }
        $id->update($edit);
        Mail::to($request->email)->send(new UserMail($id));
        return redirect()->route('verifypage')->with('message','Edit Detail Success!');
    }

    public function add(Request $request){
        $add=$request->validate([
            'p_name'=>['required','min:3'],
            'picture'=>'required',
            'mass'=>['required','min:1'],
            'price'=>'required'
        ]);
        if ($request->hasFile("picture")) {
            $add['picture']=$request->file("picture")->store("logos","public");
        }
        products::create($add);
        return back()->with('message','Add Product Success!');
    }
}