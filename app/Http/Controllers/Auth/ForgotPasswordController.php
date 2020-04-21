<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Extensions\Auth\SendsPasswordReset;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */    

    //use SendsPasswordResetEmails;
    use SendsPasswordReset;

    // /**
    //  * Display the form to request a password reset link.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function showPhoneRequestForm()
    // {
    //     return view('auth.passwords.phone.request');
    // }



    // public function sendVerificationCodeSms(Request $request)
    // {
    //   $phone = $this->validatePhone($request);

    //   $user = getUserBy($phone['phone']);
    //   set prev veri time null
    //   createVerificationCodeInUserTable
    //   verify
    //   senedRestPageWithToken
    //   dd($phone['phone']);
    // }
    
    //  public function validatePhone(Request $request)
    // {
    //     //dd($request->all());
    //     return $request->validate(['phone' => 'required']);
    // }

}