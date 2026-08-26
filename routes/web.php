<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

// --- Autenticação --- 

Route::view('/login', 'auth.login')->name('auth.login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
