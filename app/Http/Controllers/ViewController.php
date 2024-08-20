<?php

namespace App\Http\Controllers;
use App\Models\addresses;
use App\Models\products;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function main(){
        $data = products::orderBy('created_at', 'desc')->take(6)->get();
        $data2 = products::orderBy('p_name', 'asc')->get();   
        return view('main', [
            'data' => $data,
            'data2' => $data2
        ]);
    }
    public function view_detail(){
        return view('view_detail');
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
    public function address(){
        return view('address',[
            'data'=>addresses::all()
        ]);
    }
    public function addaddress(){
        return view('add_address');
    }
    public function editaddress($id){
        return view('edit_address',[
            'data'=>addresses::find($id)
        ]);
    }
    public function addpage(){
        return view('add');
    }
}
