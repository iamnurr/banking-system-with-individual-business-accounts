<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('transactions')
                ->with(RESPONSE_TYPE_SUCCESS, __('Login Successfully.'));
        }
        return redirect()->route('welcome')
            ->with(RESPONSE_TYPE_WARNING, __('Failed to login'));
    }

    public function destroy(Request $request)
    {
        if (auth()->check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('welcome')->with(RESPONSE_TYPE_SUCCESS, __('Logout Successfully.'));
        }

        return redirect()->route('welcome')->with(RESPONSE_TYPE_WARNING, __('Failed to logout.'));
    }
}
