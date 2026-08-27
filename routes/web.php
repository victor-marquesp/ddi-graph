<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');


// --- Admnin --- 

Route::resource('users', UserController::class)->middleware('auth');

// --- Autenticação --- 

Route::view('/required', 'auth.required')->name('auth.required');

Route::view('/login', 'auth.login')->name('auth.login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
