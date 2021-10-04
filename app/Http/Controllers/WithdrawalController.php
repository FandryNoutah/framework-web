<?php

namespace App\Http\Controllers;

use App\User;
use App\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\WithdrawalRequest;

class WithdrawalController extends Controller
{
    public function index(){
        $user = Auth::user();

        if($user->is_admin){
            $withdrawals = Withdrawal::all();
            $withdrawals_title = "Recent withdrawals";
        } else {
            $withdrawals = $user->withdrawals;
            $withdrawals_title = "My withdrawals";
        }

        return view('withdrawal.index', [
            'withdrawals'       =>  $withdrawals,
            'withdrawals_title' =>  $withdrawals_title
        ]);
    }

    public function store(WithdrawalRequest $request){

        $request->validate([
            'amount'    =>  [
                function ($attribute, $value, $fail) {

                    if ($value > Auth::user()->balance) {
                        $fail("Your balance is insufficient for this withdrawal!");
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

        $user = User::find(Auth::id());
        $amount = floatval($request->amount);
        $admin = User::where('is_admin', 1)->first();

        $withdrawal = new Withdrawal();
        $withdrawal->amount = $amount;

        if ($user->withdrawals()->save($withdrawal)) {
            $user->balance = $user->balance - $amount;
            $admin->balance = $admin->balance - $amount;

            if($user->save()){
                $admin->save();

                $request->session()->flash('success_message', "Your withdrawal transaction have been saved successfully! Your current balance is ". $user->balance ." Ariary.");
            } else {
                $user->withdrawals->delete($withdrawal);
                $request->session()->flash('error_message', "An error has occured while removing your withdrawal from your account! Please, try again later.");
            }
        }else{
            $request->session()->flash('error_message', "An error has occured while saving your withdrawal transaction! Please, try again later.");
        }

        return redirect(route('withdrawal-index'));
    }
}
