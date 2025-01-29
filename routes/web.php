<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin',function(){
    return view('admin');
})->name('admin')->middleware('admin');

Route::get('/vendedor',function(){
    return view('vendedor');
})->name('vendedor')->middleware('vendedor');
