<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\DrugController;
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

Route::controller(DrugController::class)->group(function () {

    Route::get('/drugs', 'index')->name('drugs.index');
    Route::get('/drugs/create', 'create')->name('drugs.create')->middleware('auth');
    Route::get('/drugs/{drug}', 'show')->name('drugs.show');
    Route::get('/drugs/{drug}/edit', 'edit')->name('drugs.edit')->middleware('auth');;
    Route::post('/drugs', 'store')->name('drugs.store')->middleware('auth');;
    Route::put('/drugs/{drug}', 'update')->name('drugs.update')->middleware('auth');;
    Route::delete('/drugs/{drug}', 'destroy')->name('drugs.destroy')->middleware('auth');;

});

// --- Admin --- 

Route::resource('users', UserController::class)->middleware('auth');

// --- Autenticação --- 

Route::view('/required', 'auth.required')->name('auth.required');

Route::view('/login', 'auth.login')->name('auth.login.form')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
