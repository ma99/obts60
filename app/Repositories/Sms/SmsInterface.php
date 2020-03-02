<?php

namespace App\Repositories\Sms;

interface SmsInterface {

	public function send(array $data);
	
}