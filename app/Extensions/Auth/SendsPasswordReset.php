<?php

namespace App\Extensions\Auth;

// use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Validation\ValidationException;
//use App\Extensions\Auth\Facades\Password;
use Illuminate\Http\Request;

trait SendsPasswordReset
{
    use SendsPasswordResetEmails;
     
    public function showVerificationRequestForm()
    {
        return view('auth.passwords.phone.request');
    }

    public function sendVerificationCodeSms(Request $request)
    {
      $phone = $this->validatePhone($request);

      $response = $this->broker()->sendVerificationCode(
            $this->credentials($request)
        );

       //return $response == Password::RESET_LINK_SENT
       return $response == 'VERIFICATION_CODE_SENT'
                    ? $this->sendVerificationCodeResponse($request, $response)
                    : $this->sendVerificationCodeFailedResponse($request, $response);
     
    }
    
     public function validatePhone(Request $request)
    {
        //dd($request->all());
        return $request->validate(['phone' => 'required']);
    }

    // public function sendResetLinkEmail(Request $request)
    // {
    //     $this->validateEmail($request);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //      $response = $this->broker()->sendResetLink(
    //         $this->credentials($request)
    //     );

    //     return $response == Password::RESET_LINK_SENT
    //                 ? $this->sendResetLinkResponse($request, $response)
    //                 : $this->sendResetLinkFailedResponse($request, $response);
    // }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    // protected function validateEmail(Request $request)
    // {
    //     $request->validate(['email' => 'required|email']);
    // }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'phone');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendVerificationCodeResponse(Request $request, $response)
    {
        //return back()->with('status', trans($response));
        return redirect()->route('password.verify.show', ['phone' => $request->phone]);
        // return view('auth.passwords.phone.verify', ['phone' => $request->phone]);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendVerificationCodeFailedResponse(Request $request, $response)
    {
        $response = 'Sorry! Unable to find a user with this phone number';

        return back()
                ->withInput($request->only('phone'))
                ->withErrors(['phone' => trans($response)]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    // public function broker()
    // {
    //     return Password::broker();
    // }

    public function showVerificationSubmitForm(Request $request)
    {
        return view('auth.passwords.phone.verify', ['phone' => $request->phone]);
    }

    public function verify(Request $request)
    {
        $user = $this->broker()->getUser(
            $this->credentials($request)
        );

        if ($user->verificationCodeExpired($user->updated_at)) {
          throw ValidationException::withMessages([
                'code' => ['The code is expired! Please try again or request another call.'],
            ]);
        }

        if ($user->verification_code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => ['The code your provided is wrong. Please try again or request another call.'],
            ]);
        }
        
        $token = $this->broker()->createToken($user);
        $phone = $request->phone;

        if ($user->hasVerifiedPhone()) {
            //return redirect()->route('home');
            return $this->redirectTo($token, $phone);
        }

        $user->markPhoneAsVerified();

        //return redirect()->route('home')->with('status', 'Your phone was successfully verified!');
        return $this->redirectTo($token, $phone);
    }

    // public function resend(Request $request)
    // {
    //     if ($request->user()->hasVerifiedPhone()) {
    //         return redirect($this->redirectTo($token));
    //     }

    //     //$request->user()->sendPhoneVerificationNotification();
    //     $request->user()->smsToVerify();

    //     //return back()->with('resent', true);
    //     return back()->with('status', 'Verification code has been sent!');;
    // }

    public function redirectTo($token, $phone)
    {        
        return redirect()->route('password.reset.phone', ['token' => $token, 'phone' => $phone]);
    }
}