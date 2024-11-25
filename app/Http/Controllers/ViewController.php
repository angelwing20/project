<?php

namespace App\Http\Controllers;
use App\Models\addresses;
use App\Models\products;
use App\Models\carts;
use App\Models\checkouts;
use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{  
    public function main(){
        $data = products::where('p_status','active')->orderBy('created_at', 'desc')->take(6)->get();
        $data2 = products::where('p_status','active')->orderBy('p_name', 'asc')->paginate(10);
        $data3 = products::where('p_status','active')->orderBy('p_name', 'desc')->paginate(10);
        return view('main', [
            'data' => $data,
            'data2' => $data2,
            'data3' => $data3
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
    public function verifypage_code($code){
        return view('verify',[
            'code'=>$code
        ]);
    }
    public function loginpage(){
        return view('login');
    }
    public function forgotpage(){
        return view('forgot');
    }
    public function verify_forgot($email){
        return view('verify_forgot',[
            'email'=>User::where('email',$email)->first(),
        ]);
    }
    public function verify_forgot_code($email,$code){
        return view('verify_forgot',[
            'email'=>User::where('email',$email)->first(),
            'code'=>$code
        ]);
    }
    public function forgotpwd($email){
        return view('forgotpwd',[
            'email'=>User::where('email',$email)->first()
        ]);
    }

    public function cart(){
        return view('cart',[
            'cart'=>carts::where('user_id',Auth::guard('web')->user()->id)->get(),
            'addresses'=>addresses::where('user_id',Auth::guard('web')->user()->id)->get()
        ]);
    }

    public function deletecart(carts $id){
        $delete=carts::where('id',$id->id);
        $delete->delete();
        return back();
    }

    public function purchase_list(){
        return view('purchase',[
            'checkout'=>checkouts::where('user_id',Auth::guard('web')->user()->id)->orderBy('created_at', 'desc')->get()->groupBy('order_code')
        ]);
    }

    public function cancel_order(checkouts $id){
        if ($id->status == 'pending') {
            checkouts::where('id',$id->id)->update(['status' => 'cancelled']);
            products::where('id',$id->product_id)->increment('mass', $id->mass);
            products::where('id',$id->product_id)->update(['p_status' => 'Active']);
            return back()->with('message','Order has been cancelled successfully');
        }else{
            return back()->with('message','Order on the way cannot be cancelled');
        }
    }

    public function user(){
        return view('user');
    }
    public function address(){
        return view('address',[
            'data'=>addresses::where('user_id',Auth::guard('web')->user()->id)->get()
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
}