<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('authentication.login');
    }

    public function authenticate(LoginRequest $request){
        // dd($request);
        $credentials = $request->only('email', 'password');
        $remember = false;

        if (Auth::attempt($credentials)) {
            return redirect()->intended();
        }else {
            $request->session()->flash('error_message', "Credentials are incorrect!");
            return redirect(route('login'));
        }
    }

    public function logout(){
        Auth::logout();
        return redirect(route('login'));
    }
}
