<?php

namespace App\Http\Controllers;

use App\Models\checkouts;
use Illuminate\Http\Request;
use App\Models\products;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    //
    public function admin_loginpage(){
        return view('admin.admin_loginpage');
    }

    public function admin_login(Request $request){
        $login=$request->validate([
            'name'=>'required',
            'password'=>'required'
        ]);
        if (Auth::guard('admin')->attempt($login)) {
            return redirect()->route('admin_main')->with('message','Login Success!');
        }else{
            return redirect()->route('admin_loginpage')->with('message','Login Failed!');
        }
    }

    public function admin_main(){
        return view('admin.admin_main',[
            'active'=>products::where('p_status','active')->get(),
            'empty'=>products::where('p_status','empty')->get(),
            'all'=>products::all(),
            'order'=>checkouts::where('status','pending')->orwhere('status','on-the-way')->orderBy('created_at','asc')->get()
        ]);
    }

    public function admin_logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin_loginpage')->with('message','Logout Success!');
    }

    public function add(Request $request){
        $add=$request->validate([
            'p_name'=>['required','min:3'],
            'picture'=>'required',
            'description'=>'nullable',
            'mass'=>['required','min:1'],
            'price'=>'required',
            'p_status'=>'Active'
        ]);
        if ($request->hasFile("picture")) {
            $add['picture']=$request->file("picture")->store("logos","public");
        }
        products::create($add);
        return back()->with('message','Add Product Success!');
    }

    public function edit(Request $request,products $id){
        if ($id->p_status=='Active') {
            $id->update(array('p_status'=>'Empty'));
        }else{
            $id->update(array('p_status'=>'Active'));
        }
        return back()->with('message','Edit Product Success!');
    }

    public function editproduct_page($id){
        return view('admin.admin_editproduct',[
            'id'=>products::find($id)
        ]);
    }

    public function editproduct(Request $request,products $id){
        $edit=$request->validate([
            'picture'=>'nullable',
            'p_name'=>['required','min:3'],
            'mass'=>['required','min:1'],
            'price'=>'required',
            'description'=>'nullable',
        ]);
        if ($request->hasFile("picture")) {
            $edit['picture']=$request->file("picture")->store("logos","public");
        }
        $id->update($edit);
        return back()->with('message','Edit Product Success!');
    }
}
