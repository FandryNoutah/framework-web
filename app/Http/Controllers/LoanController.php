<?php

namespace App\Http\Controllers;

use App\Loan;
use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            $attachment = $request->file('attachment')->store('documents/loan/'.Auth::id(), ['disk' => 'uploads']);
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

    public function show($id_loan){
        $loan = Loan::find($id_loan);
        $user = $loan->user()->first();

        return view('loan.show', [
            'loan'  =>  $loan,
            'user'  =>  $user
        ]);
    }

    public function attachment($id_loan){
        $loan = Loan::find($id_loan);

        $attachment = $loan->attachment;

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($attachment, 'attachment.pdf', $headers);
    }

    public function confirm($id_loan, Request $request){
        $loan = Loan::find($id_loan);

        $user = $loan->user()->first();
        $admin = User::where('is_admin', 1)->first();

        if ($admin->balance < $loan->amount) {
            $request->session()->flash('error_message', "Bank's balance is not enough for this loan!");

            return redirect(route('loan-show', ['id_loan' => $id_loan]));
        }else{

            $user->balance = $user->balance + $loan->amount;
            $admin->balance = $admin->balance - $loan->amount;

            $user->save();
            $admin->save();

            $loan->status = "Unpaid";
            $loan->save();

            $request->session()->flash('success_message', "User's loan has been accepted successfully!");

            return redirect(route('loan-show', ['id_loan' => $id_loan]));
        }

    }

    public function reject($id_loan, Request $request){
        $loan = Loan::find($id_loan);

        $loan->status = "Rejected";

        $loan->save();

        $request->session()->flash('success_message', "User's loan has been rejected successfully!");
        return redirect(route('loan-show', ['id_loan' => $id_loan]));
    }
}
