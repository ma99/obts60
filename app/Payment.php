<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function setPaymentDataAttribute($value)
    {
        $this->attributes['payment_data'] = base64_encode(serialize($value));
    }

    public function getPaymentDataAttribute($value)
    {   
        return unserialize(base64_decode($value));
    }

    public function setValidationDataAttribute($value)
    {
        $this->attributes['validation_data'] = base64_encode(serialize($value));
    }

    public function getValidationDataAttribute($value)
    {
        return unserialize(base64_decode($value));
    }

    public function saveDataBy(Booking $booking, array $data, $paymentMethod = 'card')
    {    	
    	$this->updateOrCreate(
    		['booking_id' => $booking->id],
    		[
    			'transaction_id' => $data['tran_id'],
    			'amount'	=> $data['total_amount'],
    			'currency'	=> $data['currency'],
    			'method' => $paymentMethod,
    			//'payment_data'	=> ($paymentMethod == 'card') ? $data : null,
    			'status' => ($paymentMethod == 'card') ? $data['status'] : 'paid',
                'received_by' => ($paymentMethod == 'card') ? null : $data['received_by'],      			
    		]
    	);
    }

    public function detailsBy($transactionId)
    {
    	return Payment::where('transaction_id', $transactionId)->first();
    }

    public function updatePayment($status, $transactionId)
    {
    	$payment = $this->detailsBy($transactionId);

    	return $payment->update(['status' => $status]);
    }
}