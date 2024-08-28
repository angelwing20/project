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
    public function addcart(Request $request, products $id){
        if (Auth::user()!==null) {
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
        }else{
            return redirect()->route('loginpage');
        } 
    }
    public function addcart_view(Request $request,products $id){
        if (Auth::user()!==null) {
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
        }else{
            return redirect()->route('loginpage');
        } 
    }

    public function checkout(Request $request){
    
        // 获取提交的所有商品ID和对应的质量（mass）
        $product_ids = $request->input('product_id');
        $masses = $request->input('mass');

        // 验证：确保数组长度一致并且不为空
        if (count($product_ids) != count($masses)) {
            return redirect()->back()->with('message', 'Data mismatch!');
        }

        // 生成唯一的订单代码
        $order_code = rand(100000, 999999);

        // 验证是否选择了地址（仅在 delivery 情况下）
        if ($request->delivery_type === 'delivery' && $request->address == null) {
            return redirect()->route('addaddress')->with('message', 'Please Add A Address To Complete Delivery Order!');
        }

        // 遍历商品ID和质量数组，插入到数据库中
        foreach ($product_ids as $index => $product_id) {
            $mass = $masses[$index];

            // 获取产品的单价
            $product = products::find($product_id);
            if (!$product) {
                return redirect()->back()->with('message', 'Product not found!');
            }

            // 计算总价
            $total_price = ($mass / 100) * $product->price;

            // 获取地址，如果选择的是 delivery
            $address = $request->delivery_type === 'delivery' ? $request->address : '';

            // 创建订单记录
            checkouts::create([
                'order_code'   => $order_code,
                'user_id'      => Auth::user()->id,
                'product_id'   => $product_id,
                'mass'         => $mass,
                'price'        => $product->price,
                'delivery_type'=> $request->delivery_type,
                'address'      => $address,
                'price'        => $total_price,
                'status'       => 'on-the-way',
            ]);
            $cart=carts::where('user_id',Auth::user()->id)->where('product_id',$product_id)->first();
            if ($cart) {
                $cart->delete();
            }
        } 
        // 返回成功的视图或重定向
        return redirect()->route('main')->with('message', 'Order placed successfully!');
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
        Auth::login($user);
        Mail::to($user->email)->send(new UserMail($user));
        return redirect()->route('verifypage')->with('message','Register Success!');
    }

    public function verify(Request $request){
        $condition=User::where('email','=',Auth::user()->email);
        $data=$condition->get();
        if ($data[0]->verify_code==$request['verify_code']) {
            if (Auth::user()->verify_time!==Null) {
                return redirect()->route('main');
            }
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

    public function reset_pwd(Request $request,$email){
        $condition=User::where('email',$email);
        $reset=$request->validate([
            'password'=>'required|confirmed|min:6'
        ]);
        $reset['password']=bcrypt($reset['password']);
        $condition->update($reset);
        return redirect()->route('loginpage')->with('message','Password Already Change!');
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
            'gender'=>'nullable'
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
        $add['user_id']=Auth::user()->id;
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