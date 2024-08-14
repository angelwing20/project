<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function main(){
        return view('main');
    }
    public function registerpage(){
        return view('register');
    }
    public function verifypage(){
        return view('verify');
    }
    public function loginpage(){
        return view('login');
    }
    public function user(){
        return view('user');
    }
    public function addpage(){
        return view('add');
    }
}
