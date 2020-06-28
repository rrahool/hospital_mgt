<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    /*
     * showing login page
     * */
    public function showLoginForm(){

        if (Auth::check()){
            return redirect('/home');
        }else{
            return view('auth.login_form');
        }

    }


    public function userLogin(Request $request){

        //echo $request->email.', '.$request->password;
        $this->validate($request, [
            'email'=> 'required|email|max:100',
            'password'=> 'required|max:100',
        ]);

        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){

            return redirect('/home');

        }else{
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash('message.content',"Email Or Password Doesn't match");

            return redirect('/');
        }

    }


    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }

}
