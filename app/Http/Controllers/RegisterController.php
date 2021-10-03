<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(){
        return view('authentication.register');
    }

    public function store(RegisterRequest $request){
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $email = $request->email;
        $password = $request->password;

        $user = new User();

        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->password = Hash::make($password);

        if ($user->save()) {
            $request->session()->flash('success_message', "Your account has been created successfully! You can now log in with your email and your password.");
        }else{
            $request->session()->flash('error_message', "An error has occured while saving your account! Please, try again later.");
            return redirect(route('register'));
        }

        return redirect(route('login'));
    }
}
