<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(){
        return view('authentication.register');
    }

    public function store(RegisterRequest $request){
        dd($request);
    }
}
