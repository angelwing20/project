<?php

use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\checkuser;

Route::controller(ViewController::class)->group(function(){
    Route::get('/cart','cart')->name('cart')->middleware(checkuser::class);
    Route::get('/deletecart/{id}','deletecart')->name('deletecart')->middleware(checkuser::class);

    Route::get('/','main')->name('main');
    Route::get('/view_detail/{id}','view_detail')->name('view_detail');

    Route::get('/registerpage','registerpage')->name('registerpage');
    Route::get('/verifypage','verifypage')->name('verifypage');
    Route::get('/verifypage/{code}','verifypage_code')->name('verifypage_code');
    Route::get('/loginpage','loginpage')->name('loginpage');

    Route::get('/forgotpage','forgotpage')->name('forgotpage');
    Route::get('/verify_forgot/{email}','verify_forgot')->name('verify_forgot');
    Route::get('/verify_forgot/{email}/{code}','verify_forgot_code')->name('verify_forgot_code');
    Route::get('/forgotpwd/{email}','forgotpwd')->name('forgotpwd');

    Route::get('/user','user')->name('user')->middleware(checkuser::class);
    Route::get('/address','address')->name('address')->middleware(checkuser::class);
    Route::get('/addaddress','addaddress')->name('addaddress')->middleware(checkuser::class);
    Route::get('/editaddress/{id}','editaddress')->name('editaddress')->middleware(checkuser::class);
});

Route::controller(UserController::class)->group(function(){
    Route::post('/addcart/{id}','addcart')->name('addcart')->middleware(checkuser::class);
    Route::post('/addcart_view/{id}','addcart_view')->name('addcart_view')->middleware(checkuser::class);
    Route::post('/checkout','checkout')->name('checkout')->middleware(checkuser::class);

    Route::post('/register','register')->name('register');
    Route::post('/verify','verify')->name('verify');  
    Route::post('/login','login')->name('login');

    Route::post('/forgot','forgot')->name('forgot');
    Route::post('/verify_forgotpwd/{email}','verify_forgotpwd')->name('verify_forgotpwd');
    Route::post('/resend/{email}','resend')->name('resend');
    Route::post('/reset_pwd/{email}','reset_pwd')->name('reset_pwd');

    Route::post('/edituser/{id}','edituser')->name('edituser')->middleware(checkuser::class);
    Route::post('/addaddress','addaddress')->name('addaddress')->middleware(checkuser::class);
    Route::post('/editaddress/{id}','editaddress')->name('editaddress')->middleware(checkuser::class);
    Route::delete('/deleteaddress/{id}','deleteaddress')->name('deleteaddress')->middleware(checkuser::class);

    Route::post('/logout','logout')->name('logout')->middleware(checkuser::class);
});

Route::controller(SellerController::class)->group(function(){
    Route::get('/addpage','addpage')->name('addpage');
    Route::post('/add','add')->name('add');
});