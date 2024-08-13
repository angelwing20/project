<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function(){
    Route::get('/','first')->name('first');
    Route::get('/registerpage','registerpage')->name('registerpage');
    Route::post('/register','register')->name('register');
    Route::get('/loginpage','loginpage')->name('loginpage');
    Route::get('/logout','logout')->name('logout');
});