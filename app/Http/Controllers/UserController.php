<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('ajax', ['only' => ['switch']]);
    }

    public function index(){

        $users = User::where('is_admin', 0)->get();

        return view('user.index', [
            'users' =>  $users
        ]);
    }

    public function show($id_user){
        $user = User::find($id_user);

        return view('user.show', [
            'user'  =>  $user
        ]);
    }

    public function switch($id_user, Request $request){
        $user = User::find($id_user);

        $active = !boolval($request->active);

        $status = "deactivated";
        if ($active) {
            $status = "activated";
        }

        $user->active = $active;

        if ($user->save()) {
            $request->session()->flash('success_message', "User account has been ". $status ." successfully!");
        }else{
            $request->session()->flash('error_message', "User account can't been ". $status ."! Please, try again later.");
        }

        return response()->json([
            'finished'   =>  true
        ]);
    }

    public function destroy($id_user, Request $request){
        $user = User::find($id_user);

        if ($user->delete()) {
            $request->session()->flash('success_message', "User number ".$id_user." has been deleted successfully!");
        }else{
            $request->session()->flash('error_message', "An error has occured while deleting user! Please, try again later.");
        }

        return redirect(route('user-index'));
    }
}
