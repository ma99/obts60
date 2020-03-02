<?php

namespace App\Repositories\Sms;


class NexmoSms implements SmsInterface
{
	public function send(array $data)
	{
		$NEXMO_API_KEY = env('NEXMO_API_KEY');
		$NEXMO_API_SECRET = env('NEXMO_API_SECRET');
		$FROM_NUMBER = $data['from_number'];
		$TO_NUMBER = $data['to_numbers'];
		$TEXT = $data['message'];


		$basic  = new \Nexmo\Client\Credentials\Basic($NEXMO_API_KEY, $NEXMO_API_SECRET);
		$client = new \Nexmo\Client($basic);

		$message = $client->message()->send([
	        'to' => $TO_NUMBER,
	        'from' => $FROM_NUMBER,
	        'text' => $TEXT,
	    ]);
	    $response = $message->getResponseData();

		// try {
		//     $message = $client->message()->send([
		//         'to' => $data['numbers'],
		//         'from' => 'Acme Inc',
		//         'text' => $data['message'],
		//     ]);
		//     $response = $message->getResponseData();

		//     // if($response['messages'][0]['status'] == 0) {
		//     //     echo "The message was sent successfully\n";
		//     // } else {
		//     //     echo "The message failed with status: " . $response['messages'][0]['status'] . "\n";
		//     // }
		// } catch (Exception $e) {
		//     //echo "The message was not sent. Error: " . $e->getMessage() . "\n";
		// }
	}
	
} 