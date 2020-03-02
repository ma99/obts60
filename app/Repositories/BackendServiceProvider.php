<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Sms\SmsInterface',
            //'App\Repositories\Sms\NexmoSms'
            'App\Repositories\Sms\AlphaSms'
        );
    }

    public function boot()
    {
        //
    }
}
