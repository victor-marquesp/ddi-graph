<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function login(LoginRequest $request) {

        if( Auth::attempt($request->credentials(), $request->remember()) ) {

            $request->session()->regenerate();

            return redirect()->route('welcome')->with('success', 'User logged');
        }

        return redirect()->route('welcome')->with('error', 'Loggin Failed');
    }

    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'User Logout');
    }

}
