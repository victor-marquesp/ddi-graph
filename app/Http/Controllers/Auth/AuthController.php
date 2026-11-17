<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    public function login(LoginRequest $request) {

        if (Auth::attempt($request->credentials(), $request->remember())) {

            $request->session()->regenerate();

            return redirect()
                ->route('welcome')
                ->with('success', 'Autenticação realizada com sucesso.');
        }

        return redirect()
            ->route('auth.login.form')
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'E-mail ou senha inválidos.');
    }

    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'User Logout');
    }

}
