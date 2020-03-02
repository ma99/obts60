<?php

namespace App\Repositories\Sms;


class AlphaSms implements SmsInterface
{
	public function send(array $data)
	{
		$username = env('ALPHA_API_USER_NAME');
		$hash = env('ALPHA_API_HASH_TOKEN');
		//$FROM_NUMBER = $data['from_number'];
		$numbers = $data['to_numbers'];
		$message = $data['message'];

		// $username = "YOUR_API_USERNAME";
	 //    $hash = "YOUR_API_HASH_TOKEN"; 
	 //    $numbers = "017xxxxxxxx,018xxxxxxxx"; //Recipient Phone Number multiple number must be separated by comma
	 //    $message = "Simple text message.";

		$params = array('u'=>$username, 'h'=>$hash, 'op'=>'pv', 'to'=>$numbers, 'msg'=>$message);

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "http://alphasms.biz/index.php?app=ws");
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    $response = curl_exec($ch);
	    curl_close ($ch);


	    // $params = array('app'=>'ws', 'u'=>$username, 'h'=>$hash, 'op'=>'pv', 'unicode'=>'1','to'=>$numbers, 'msg'=>$message);

	    // $ch = curl_init();
	    // curl_setopt($ch, CURLOPT_URL, "http://alphasms.biz/index.php?".http_build_query($params, "", "&"));
	    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Accept:application/json"));
	    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	    // $response = curl_exec($ch);
	    // curl_close ($ch);
		
	}
	
} 