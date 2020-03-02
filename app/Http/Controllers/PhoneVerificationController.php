<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneVerificationController extends Controller
{
	protected $redirectTo = '/home';

	public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('signed')->only('verify');
        // $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedPhone()
                        //? redirect()->route('home')
                        ? redirect($this->redirectPath())
                        : view('phone.verify');
    }

    public function verify(Request $request)
    {
        if ($request->user()->verification_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => ['The code your provided is wrong. Please try again or request another call.'],
            ]);
        }

        if ($request->user()->hasVerifiedPhone()) {
            //return redirect()->route('home');
            return redirect($this->redirectPath());
        }

        $request->user()->markPhoneAsVerified();

        //return redirect()->route('home')->with('status', 'Your phone was successfully verified!');
        return redirect($this->redirectPath())->with('status', 'Your phone was successfully verified!');
    }

     public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedPhone()) {
            return redirect($this->redirectPath());
        }

        //$request->user()->sendPhoneVerificationNotification();
        $request->user()->smsToVerify();

        //return back()->with('resent', true);
        return back()->with('status', 'Verification code has been sent!');;
    }

    public function redirectPath()
    {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
