<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function(){
    Route::get('/','main')->name('main');
    Route::get('/registerpage','registerpage')->name('registerpage');
    Route::post('/register','register')->name('register');
    Route::get('/verify','verify')->name('verify');
    Route::get('/loginpage','loginpage')->name('loginpage');
    Route::post('/login','login')->name('login');
    Route::get('/logout','logout')->name('logout');
});