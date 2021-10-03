<?php

namespace App\Http\Controllers;

use App\User;
use App\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DepositRequest;
use Illuminate\Support\Facades\Hash;

class DepositController extends Controller
{
    public function index(){
        $user = Auth::user();

        if ($user->is_admin) {
            $deposits = Deposit::all();
            $deposits_title = "Recent deposits";
        } else {
            $deposits = $user->deposits;
            $deposits_title = "My deposits";
        }

        return view('deposit.index', [
            'deposits'          =>  $deposits,
            'deposits_title'    =>  $deposits_title
        ]);
    }

    public function store(DepositRequest $request){
        $request->validate([
            'amount'    =>  [
                function ($attribute, $value, $fail) {
                    if ($value % 100 !== 0) {
                        $fail("Amount must be divisible by 100!");
                    }
                },
            ],
            'password'  =>  [
                function ($attribute, $value, $fail) {
                    $password = Auth::user()->password;

                    if (!Hash::check($value, $password)) {
                        $fail("Incorrect password! Try again.");
                    }
                }
            ]
        ]);

        $amount = floatval($request->amount);
        $user = User::find(Auth::id());

        $deposit = new Deposit();
        $deposit->amount = $amount;

        if ($user->deposits()->save($deposit)){
            $user->balance = $user->balance + $amount;

            if($user->save()){
                $request->session()->flash('success_message', "Your deposit transaction have been saved successfully! Your current balance is ". $user->balance ." Ariary.");
            } else {
                $user->deposits()->delete($deposit);
                $request->session()->flash('error_message', "An error has occured while adding deposit into your account! Please, try again later.");
            }
        } else {
            $request->session()->flash('error_message', "An error has occured while saving your deposit transaction! Please, try again later.");
        }

        return redirect(route('deposit-index'));
    }
}
