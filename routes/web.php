<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::controller(ClassificationController::class)->group(function () {

    Route::get('/classifications', 'index')->name('classifications.index');
    Route::get('/classifications/create', 'create')->name('classifications.create')->middleware('auth');
    Route::get('/classifications/{classification}', 'show')->name('classifications.show');
    Route::get('/classifications/{classification}/edit', 'edit')->name('classifications.edit')->middleware('auth');;
    Route::post('/classifications', 'store')->name('classifications.store')->middleware('auth');;
    Route::put('/classifications/{classification}', 'update')->name('classifications.update')->middleware('auth');;
    Route::delete('/classifications/{classification}', 'destroy')->name('classifications.destroy')->middleware('auth');;

});

// --- Admin --- 

Route::resource('users', UserController::class)->middleware('auth');

// --- Autenticação --- 

Route::view('/required', 'auth.required')->name('auth.required');

Route::view('/login', 'auth.login')->name('auth.login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
