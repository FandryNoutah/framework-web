<?php

namespace App\Http\Controllers;

use App\Loan;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoanController extends Controller
{
    public function index(){
        $user = Auth::user();

        if ($user->is_admin) {
            $loans = Loan::all();
            $loans_title = "Recent loans";
        }else{
            $loans = $user->loans;
            $loans_title = "My loans";
        }

        return view('loan.index', [
            'loans'         =>  $loans,
            'loans_title'   =>  $loans_title
        ]);
    }

    public function store(LoanRequest $request){
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
        $description = $request->description;
        $status = "Waiting";

        try {
            $attachment = $request->file('attachment')->store('uploads/documents/loan/'.Auth::id(), ['disk' => 'uploads']);
        } catch (Exception $e) {
            $request->session()->flash('error_message', "An error has occured while uploading your document! Please, try again later.");
            return redirect(route('loan-index'));
        }

        $user = User::find(Auth::id());
        $loan = new Loan();
        $loan->amount = $amount;
        $loan->description = $description;
        $loan->status = $status;
        $loan->attachment = $attachment;

        if ($user->loans()->save($loan)) {
            $request->session()->flash('success_message', "Your deposit transaction have been saved successfully! Your current balance is ". $user->balance ." Ariary.");
        } else {
            $request->session()->flash('error_message', "An error has occured while saving your loan application! Please, try again later.");
        }

        return redirect(route('loan-index'));
    }
}
