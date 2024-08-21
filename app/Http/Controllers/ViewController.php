<?php

namespace App\Http\Controllers;
use App\Models\addresses;
use App\Models\products;
use App\Models\carts;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function main(){
        $data = products::orderBy('created_at', 'desc')->take(6)->get();
        $data2 = products::orderBy('p_name', 'asc')->paginate(10);
        return view('main', [
            'data' => $data,
            'data2' => $data2
        ]);
    }
    public function cart(){
        return view('cart',[
            'cart'=>carts::where('user_id',Auth::user()->id)->get()
        ]);
    }
    public function view_detail($id){
        return view('view_detail',[
            'data'=>products::find($id)
        ]);
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