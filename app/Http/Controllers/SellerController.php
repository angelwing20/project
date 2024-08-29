<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class SellerController extends Controller
{
    //
    public function addpage(){
        return view('add');
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
