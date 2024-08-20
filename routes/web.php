<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\UserController;

Route::controller(ViewController::class)->group(function(){
    Route::get('/','main')->name('main');
    Route::get('/view/{id}','view')->name('view');
    Route::get('/registerpage','registerpage')->name('registerpage');
    Route::get('/verifypage','verifypage')->name('verifypage');
    Route::get('/loginpage','loginpage')->name('loginpage');
    Route::get('/user','user')->name('user');
    Route::get('/address','address')->name('address');
    Route::get('/addaddress','addaddress')->name('addaddress');
    Route::get('/editaddress/{id}','editaddress')->name('editaddress');
    Route::get('/addpage','addpage')->name('addpage');
});

Route::controller(UserController::class)->group(function(){
    Route::post('/register','register')->name('register');
    Route::post('/verify','verify')->name('verify');  
    Route::post('/login','login')->name('login');
    Route::post('/logout','logout')->name('logout');
    Route::post('/edituser/{id}','edituser')->name('edituser');
    Route::post('/addaddress','addaddress')->name('addaddress');
    Route::post('/editaddress/{id}','editaddress')->name('editaddress');
    Route::delete('/deleteaddress/{id}','deleteaddress')->name('deleteaddress');
    Route::post('/add','add')->name('add');
});