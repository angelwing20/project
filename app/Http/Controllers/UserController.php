<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Mail\UserMail;
use App\Models\User;
use App\Models\products;
use App\Models\addresses;
use App\Models\carts;
use App\Models\checkouts;
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
        Auth::guard('web')->login($user);
        Mail::to($user->email)->send(new UserMail($user));
        return redirect()->route('verifypage')->with('message','Register Success!');
    }

    public function verify(Request $request){
        $condition=User::where('email','=',Auth::guard('web')->user()->email);
        $data=$condition->get();
        if ($data[0]->verify_code==$request['verify_code']) {
            if (Auth::guard('web')->user()->verify_time!==Null) {
                return redirect()->route('loginpage');
            }
            $condition->update(array('verify_time'=>'1'));
            return redirect()->route('main')->with('message','Verify Success!');
        }else{
            return back()->with('message','Verify Failed!');
        }
    }

    public function login(Request $request){
        $users=$request->validate([
            'email'=>['required','email'],
            'password'=>['required','min:6']
        ]);
        if (Auth::guard('web')->attempt($users)) {
            $request->session()->regenerate();
            if (Auth::guard('web')->user()->verify_time==='1') {
                return redirect()->route('main')->with('message','Login Success!');
            }else{
                return redirect()->route('verifypage')->with('message','Please verify account!');
            }
        }else{
            return redirect()->route('loginpage')->with('message','Wrong Email or Password!');
        }
    }

    public function forgot(Request $request){
        $forgot=User::where('email',$request->email)->first();
        if ($forgot) {
            $forgot['verify_code']=rand(100000,999999);
            $forgot->update();
            Mail::to($request->email)->send(new OtpMail($forgot));
            return redirect()->route('verify_forgot',['email'=>$request->email]);
        }
        return redirect()->route('forgotpage')->with('message','No Have Account!');
    }

    public function verify_forgotpwd(Request $request,$email){
        $verify=User::where('verify_code',$request->verify_code)->first();
        if ($verify) {
            return redirect()->route('forgotpwd',['email'=>$email]);
        }
        return back()->with('message','Wrong Verify Code!');
    }

    public function resend($email){
        $resend=User::where('email',$email)->first();
        $code=rand(100000,999999);
        $resend->update(['verify_code' => $code]);
        Mail::to($email)->send(new OtpMail($resend));
        return redirect()->route('verify_forgot',$email)->with('message','Resend Success!');
    }

    public function reset_pwd(Request $request,$email){
        $condition=User::where('email',$email);
        $reset=$request->validate([
            'password'=>'required|confirmed|min:6'
        ]);
        $reset['password']=bcrypt($reset['password']);
        $condition->update($reset);
        return redirect()->route('loginpage')->with('message','Password Already Change!');
    }

    public function addcart(Request $request, products $id){
        $cart = carts::where('user_id', Auth::user()->id)->where('product_id', $id->id)->exists();
        if ($cart) {
            return redirect()->route('cart')->with('message', 'Already Have In Cart!');
        }else{
            carts::create([
                'user_id' => Auth::user()->id,
                'product_id' => $id->id,
                'cart_mass' => $id->mass,
                'cart_price' => $id->price
            ]);
            return back()->with('message', 'Add Cart Success!');
        }
    }
    public function addcart_view(Request $request,products $id){
        $cart = carts::where('user_id', Auth::user()->id)->where('product_id', $id->id)->exists();
        if ($cart) {
            return back()->with('message', 'Already Have In Cart!');
        }else{
            carts::create([
                'user_id' => Auth::user()->id,
                'product_id' => $id->id,
                'cart_mass' => $request->mass,
                'cart_price' => $id->price
            ]);
            return back()->with('message', 'Add Cart Success!');
        }
    }

    public function checkout(Request $request){

        $product_ids = $request->input('product_id');
        $masses = $request->input('mass');

        $order_code = rand(100000, 999999);

        if ($request->delivery_type === 'delivery' && $request->address == null) {
            return redirect()->route('addaddress')->with('message', 'Please Add A Address To Complete Delivery Order!');
        }

        foreach ($product_ids as $array => $product_id) {
            $mass = $masses[$array];

            $product = products::find($product_id);
            if ($product->p_status == 'Empty') {
                carts::join('products', 'carts.product_id', '=', 'products.id')->where('carts.user_id', Auth::guard('web')->user()->id)->where('products.id', $product_id)->delete();
                return redirect()->route('main')->with('message', "Product ".$product->p_name." is Empty!");
            }else{
                $total_price = ($mass / 100) * $product->price;

                $address = $request->delivery_type === 'delivery' ? $request->address : '';

                checkouts::create([
                    'order_code'   => $order_code,
                    'user_id'      => Auth::guard('web')->user()->id,
                    'product_id'   => $product_id,
                    'mass'         => $mass,
                    'price'        => $product->price,
                    'delivery_type'=> $request->delivery_type,
                    'address'      => $address,
                    'price'        => $total_price,
                    'status'       => 'pending',
                ]);
                $cart=carts::where('user_id',Auth::guard('web')->user()->id)->where('product_id',$product_id)->first();
                if ($cart) {
                    $cart->delete();
                }
                $stock=$product->mass-$mass;
                products::where('id',$product_id)->update(['mass' => $stock]);
                if($stock==0){
                    $product->update(['p_status' => 'Empty']);
                }
            }

            
        } 
        return redirect()->route('main')->with('message', 'Order placed successfully!');
    }

    public function edituser(Request $request,User $id){
        $edit=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email'],
            'gender'=>'nullable|in:Male,Female'
        ]);
        if ($request->email !== $id['email']) {
            $id['verify_code']=rand(100000,999999);
            $id['verify_time']=Null;
        }
        $id->update($edit);
        if ($id['verify_time']==Null) {
            Mail::to($request->email)->send(new UserMail($id));
            return redirect()->route('verifypage')->with('message','Edit Detail Success!');
        }
        return redirect()->route('user')->with('message','Edit Detail Success!');
    }

    public function addaddress(Request $request){
        $add=$request->validate([
            'description'=>'required',
            'address1'=>'required',
            'address2'=>'required',
            'poscode'=>'required',
            'city'=>'required',
            'state'=>'required'
        ]);
        $add['user_id']=Auth::guard('web')->user()->id;
        addresses::create($add);
        return redirect()->route('address')->with('message','Add Address Success!');
    }

    public function editaddress(Request $request,addresses $id){
        $edit=$request->validate([
            'address1'=>'required',
            'address2'=>'required',
            'poscode'=>'required',
            'city'=>'required',
            'state'=>'required'
        ]);
        $id->update($edit);
        return redirect()->route('address')->with('message','Edit Address Success!');
    }

    public function deleteaddress(Request $request,addresses $id){
        $id->delete();
        return back()->with('message','Delete Address Success!');
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('main')->with('message','Logout Success!');
    }
}