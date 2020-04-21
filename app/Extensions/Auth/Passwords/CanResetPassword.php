<?php

namespace App\Extension\Auth\Passwords;

use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordBase;


trait CanResetPassword
{
    use CanResetPasswordBase;
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getPhoneForPasswordReset()
    {
        return $this->phone;
    }

    // /**
    //  * Send the password reset notification.
    //  *
    //  * @param  string  $token
    //  * @return void
    //  */
    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPasswordNotification($token));
    // }
}
