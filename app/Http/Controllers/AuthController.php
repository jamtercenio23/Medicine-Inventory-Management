<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;
use Hash;


class AuthController extends Controller
{
    

    //Forgot Password
    public function forgotpassword(){
        return view('auth.forgot');
    }

    //Post Forgot Password
    public function PostForgotPassword(Request $request){
        // dd($request->all());

        $user = User::getEmailSingle($request->email);
        //check the value if there is a matching user with that email
        //dd($user); //example to show result

        if(!empty($user)){ //if user email is found
            //dd($user); //example to show result

            //generate the remember token
            $user->remember_token = Str::random(30);
            $user->save(); //then save

            //Mail the reset password
            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            //back with success message
            return redirect()->back()->with('success','Please reset your email and check your password');


        }else{ //if there is no user found, return an error
            return redirect()->back()->with('error','Email not found');
        }

    }

    //Reset Password Token Verification
    public function reset($remember_token){
        //dd($token); //check the $token passed

        //check the token being passed
        $user = User::getTokenSingle($remember_token);

        if(!empty($user)){ //if the token is found

            $data['user'] = $user;
            return view('auth.reset',$data);

            //after creating this, create the reset form on the views/auth/reset.blade.php


        }else{ // if the token is not found
            abort(404); // abort the operation and display the error mesage
        }

    }

    //Post Reset Password with Token verification
    public function PostReset($token,Request $request){
        // dd($token);


        //check if passwordn and cpassword match
        if($request->password == $request->cpassword){

            $user = User::getTokenSingle($token);
            $user->password = Hash::make($request->password);
            //make sure a new random token is inserted for the user
            $user->remember_token = Str::random(30);
            $user->save();

            //return to the login screen with a success message
            return redirect('/login')->with('success','Password successfully reset');


        }else{ // if psw and cpsw does not match
            return redirect()->back()->with('error','Password and confirm password does not match');
        }

    }

}
