<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use Exception;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('profile.index', [
            'user'  =>  $user
        ]);
    }

    public function update(ProfileRequest $request){

        $request->validate([
            'monthly_income'    =>  [
                function ($attribute, $value, $fail) {

                    if ($value % 100 !== 0) {
                        $fail("Amount must be divisible by 100!");
                    }
                },
            ],
        ]);

        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $email = $request->email;
        $phone = intval($request->phone);
        $birth = $request->birth;
        $gender = $request->gender;
        $marital_status = $request->marital_status;
        $city = $request->city;
        $state = $request->state;
        $postal_code = intval($request->postal_code);
        $address = $request->address;
        $occupation = $request->occupation;
        $occupation_place = $request->occupation_place;
        $occupation_duration = $request->occupation_duration;
        $monthly_income = floatval($request->monthly_income);

        try {
            $identity = $request->file('identity')->store('img/users/'.Auth::id(), ['disk' => 'uploads']);
        } catch (Exception $e) {
            $request->session()->flash('error_message', "An error has occured while uploading your identity image! Please, try again later.");
            return redirect(route('profile-index'));
        }

        $user = User::find(Auth::id());

        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->phone = $phone;
        $user->birth = $birth;
        $user->gender = $gender;
        $user->marital_status = $marital_status;
        $user->city = $city;
        $user->state = $state;
        $user->postal_code = $postal_code;
        $user->address = $address;
        $user->occupation = $occupation;
        $user->occupation_place = $occupation_place;
        $user->occupation_duration = $occupation_duration;
        $user->monthly_income = $monthly_income;
        $user->identity = $identity;

        if ($user->save()) {
            $request->session()->flash('success_message', "Your profile's information have been updated successfully!");
        }else{
            $request->session()->flash('success_message', "An error has occured while updating your information! Please, try again later.");
        }

        return redirect(route('profile-index'));
    }
}
