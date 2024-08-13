<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\UserController;

Route::controller(ViewController::class)->group(function(){
    Route::get('/','main')->name('main');
    Route::get('/registerpage','registerpage')->name('registerpage');
    Route::get('/verifypage','verifypage')->name('verifypage');
    Route::get('/loginpage','loginpage')->name('loginpage');
});

Route::controller(UserController::class)->group(function(){
    Route::post('/register','register')->name('register');
    Route::post('/verify','verify')->name('verify');  
    Route::post('/login','login')->name('login');
    Route::post('/logout','logout')->name('logout');
});