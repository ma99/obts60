<?php

if(!function_exists('sendSms'))
{
    function sendSms(array $data)
    {
        return app('App\Repositories\Sms\SmsInterface')->send($data);
    }
}