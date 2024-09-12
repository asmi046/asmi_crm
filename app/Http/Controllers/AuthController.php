<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;

class AuthController extends Controller
{
    public function login(LoginFormRequest $request) {
        if (!auth()->attempt($request->validated())) {
            return redirect()
                    ->route('login')
                    ->withErrors(['email' => "Данные не верны"]);
        }

        return redirect()
                    ->route('home');
    }

    public function logout() {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()
                    ->route('login');
    }
}
