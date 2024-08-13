<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function first(){
        return view('first');
    }
    public function registerpage(){
        return view('register');
    }
    public function register(Request $request){
        $users=$request->validate([
            
        ]);
    }
    public function loginpage(){
        return view('login');
    }
}
