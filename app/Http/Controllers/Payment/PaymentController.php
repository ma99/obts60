<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Payment\PaymentInterface;
use App\Payment;
use App\Booking;
use App\Seat;

class PaymentController extends Controller
{
    protected $payByCard;
    protected $payment;
    //protected $bookingInfo = [];
    protected $seat;

    function __construct(PaymentInterface $payByCard, Payment $payment, Seat $seat)
    {
    	$this->payByCard = $payByCard;  
        $this->payment = $payment;  
        $this->seat = $seat;	
    }

    public function card(Request $request)
    {
    	$data = [];
        $bookingId = $request->input('booking_id');
        $booking = $this->findBookingBy($bookingId);   

        if($booking == null) {return;}             
            	
    	//$this->setBookingInfo($booking);
        //$booking->setSession();

        $data = $this->getDataBy($booking); // get booking information 
        
        if ($request->has(['paymentMethod', 'transaction'])) {
            
            $paymentMethod = $request->input('paymentMethod');

            $data['tran_id'] = ( $paymentMethod == 'pos' ) ? $request->input('transaction') : null;
    	   
            $this->payment->saveDataBy($booking, $data, $paymentMethod); // save data in payment table
            
            return;
        }

        $data['status'] = 'Pending';
        $data['ipn_url'] = url('/') . config('payment.sslcommerz.ipn_url');         
        
        $paymentMethod = 'card';

        $this->payment->saveDataBy($booking, $data, $paymentMethod); // save data in payment table        

    	$payment_options = $this->payByCard->makePayment($data, 'hosted'); // initiate payment

    	if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function cash(Request $request)
    {
        //$data = [];
        $bookingId = $request->input('booking_id');
        $booking = $this->findBookingBy($bookingId);   

        if($booking == null) {return;}             
                
        //$this->setBookingInfo($booking);
        //$booking->setSession();

        $data = $this->getDataBy($booking); // get booking information 
        
        $name = auth()->user()->name;
        $id = auth()->user()->id;
        $data['received_by'] = "$name'_'$id";
        
        if ($request->has('paymentMethod')) {

            $paymentMethod = $request->input('paymentMethod');

            $data['tran_id'] = ( $paymentMethod == 'pos' ) ? $request->input('transaction') : uniqid();
           
            $this->payment->saveDataBy($booking, $data, $paymentMethod); // save data in payment table

            $this->callToUpdateSeatStatusBy($bookingId);

            //echo "Transaction is successfully Completed";
            $msg = "Transaction is Successfully Completed";
            
            $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

            return view('payment.status', $options);            
        }
        return 'something went wrong';       
    }

    public function findBookingBy($id)
    {
        return Booking::find($id);
    }

    /*public function setBookingInfo(Booking $booking)
    {
        $this->bookingInfo = [
            'booking_id' => $booking->id,
            'bus_id' => $booking->bus_id,
            'schedule_id' => $booking->schedule_id,
            'travel_date' => date("d-m-Y", strtotime($booking->date)),
            'amount' => $booking->amount
        ];
    }*/

    public function getDataBy(Booking $booking)
    {
    	$post_data = array();
        
        $post_data['total_amount'] = $booking->amount;//'10'; # You cant not pay less than 10
        $post_data['tran_id'] = uniqid(); // tran_id must be unique
        $post_data['currency'] = "BDT";

        $post_data['emi_option'] = 0;
        # CUSTOMER INFORMATION
    	$customer = $this->getCustomerInfoBy($booking);

        $post_data['cus_name'] = $customer->name; //'Customer Name';
        $post_data['cus_email'] = $customer->email; //'customer@mail.com';
        $post_data['cus_phone'] = $customer->phone; //'8801XXXXXXXXX';

        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        return $post_data;
    }

    public function getCustomerInfoBy(Booking $booking)
    {
    	return $booking->creator;
    }

    public function getSession()
    {        
        return [
            'booking_id' => session('booking_id'),
            'bus_id' => session('bus_id'),
            'schedule_id' => session('schedule_id'),
            'travel_date' => session('travel_date'),           
            'amount' => session('amount')
        ];
    }

    public function callToUpdateSeatStatusBy($bookingId)
    {
        $booking = $this->findBookingBy($bookingId);
        $bookingInfo = $booking->info(); //array
        
        $this->seat->updateSeatStatus($bookingInfo);
        return;
    }

    public function paymentStatusOptions($status, $message, $title)
    {        
        $icon = $this->paymentStatusIcon($status);
    
        return [
            //'border' => 'border-success',
            'button' => ($status == 'success') ? 'success' : 'info',
            'msg' => $message,
            'icon' => $icon,                        
            'status' => $status,
            'title' => $title
        ];
    }

    public function paymentStatusIcon($status)
    {       
        // return ( $status == 'success' ) ? 'fa-check-circle' :
        //         ( $status == 'error' ) ? 'fa-times-circle' : 'exclamation-triangle';

        switch ($status) {
            case 'success':
                $icon = 'fa-check-circle';
                break;
            case 'error':
                $icon = 'fa-times-circle';
                break;            
            default:
                $icon = 'fa-exclamation-triangle';
                break;
        }
        return $icon;
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            /*$order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();*/
            
            $order_details = $this->payment->detailsBy($tran_id);

            if ($order_details->status == 'Pending') {
                //$sslc = new SslCommerzNotification();
                $validation = $this->payByCard->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    /*$update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);*/

                    $update_product = $this->payment->updatePayment('Complete', $tran_id);
                    // $booking = $this->findBookingBy($order_detials->booking_id);
                    // $bookingInfo = $booking->info(); //array
                    // $this->seat->updateSeatStatus($bookingInfo);
                    $this->callToUpdateSeatStatusBy($order_detials->booking_id);
                    //echo "Transaction is successfully Completed";
                    $msg = "Transaction is successfully Completed IPN";

                    // $options = [
                    //     'border' => 'border-success',
                    //     'button' => 'success',
                    //     'msg' => $msg,
                    //     'icon' => 'fa-check-circle',                        
                    //     'status' => 'success',
                    //     'title' => 'Thank You!'
                    // ];
                    $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

                    return view('payment.status', $options);

                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    /*$update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);*/

                    $update_product = $this->payment->updatePayment('Failed', $tran_id);

                    //echo "validation Fail";
                    $msg = "Validation Fail";
                    // $options = [
                    //     'border' => 'border-danger',
                    //     'msg' => $msg,
                    //     'icon' => 'fa-times-circle',
                    //     'status' => 'error',
                    //     'title' => 'Oops!'
                    // ];
                    $options = $this->paymentStatusOptions('error', $msg, 'Oops!');
                    $options['booking_id'] = $order_detials->booking_id;

                    return view('payment.status', $options);
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                //'echo "Transaction is already successfully Completed";
                $msg = "Transaction is already successfully Completed IPN";

                $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

                return view('payment.status', $options);
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                //echo "Invalid Transaction";
                $msg = "Invalid Transaction IPN";
                
                $options = $this->paymentStatusOptions('error', $msg, 'Oops!');

                return view('payment.status', $options);
            }
        } else {
            //echo "Invalid Data";
            $msg = "Invalid Data IPN";
            
            $options = $this->paymentStatusOptions('error', $msg, 'Oops!');
            $options['booking_id'] = $order_detials->booking_id;

            return view('payment.status', $options);
        }
    }

      public function success(Request $request)
    {
        //echo "Transaction is Successful";
        $msg = "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        //$sslc = new SslCommerzNotification();
    
        #Check order status in order tabel against the transaction id or order id.
        /*$order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();*/

        $order_detials = $this->payment->detailsBy($tran_id);

        if ($order_detials->status == 'Pending') {

                $validation = $this->payByCard->orderValidate($tran_id, $amount, $currency, $request->all());

                if ($validation == TRUE) {
                    /*
                    That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                /*$update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                echo "<br >Transaction is successfully Completed";*/
                $update_product = $this->payment->updatePayment('Complete', $tran_id);

                $this->callToUpdateSeatStatusBy($order_detials->booking_id);

                //echo "Transaction is successfully Completed";
                $msg = "Transaction is successfully Completed";
                
                $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

                return view('payment.status', $options);

            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                /*$update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);
                
                echo "validation Fail";*/

                $update_product = $this->payment->updatePayment('Failed', $tran_id);

                $msg = "Validation Fail";
                
                $options = $this->paymentStatusOptions('error', $msg, 'Oops!');
                $options['booking_id'] = $order_detials->booking_id;

                return view('payment.status', $options);

            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            //echo "Transaction is successfully Completed";
            $msg = "Transaction is successfully Completed";
            
            $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

            return view('payment.status', $options);

        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            //echo "Invalid Transaction";
            $msg = "Invalid Transaction";

            $options = $this->paymentStatusOptions('error', $msg, 'Oops!');                
            $options['booking_id'] = $order_detials->booking_id;

            return view('payment.status', $options);
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        /*$order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();*/
        
        $order_detials = $this->payment->detailsBy($tran_id);

        if ($order_detials->status == 'Pending') {

            /*$update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";*/

            $update_product = $this->payment->updatePayment('Falied', $tran_id);

            $msg = "Transaction is Falied";
                
            $options = $this->paymentStatusOptions('error', $msg, 'Oops!');            
            $options['booking_id'] = $order_detials->booking_id;

            return view('payment.status', $options);

        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            //echo "Transaction is already Successful";
            $msg = "Transaction is already Successful";
            
            $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

            return view('payment.status', $options);

        } else {
            //echo "Transaction is Invalid";
            $msg = "Transaction is Invalid";
  
            $options = $this->paymentStatusOptions('error', $msg, 'Oops!');
            $options['booking_id'] = $order_detials->booking_id;

            return view('payment.status', $options);
            }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        /*$order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();*/

        $order_detials = $this->payment->detailsBy($tran_id);

        if ($order_detials->status == 'Pending') {

           /* $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Cancelled']);
            echo "Transaction is Cancel";*/

            $update_product = $this->payment->updatePayment('Cancelled', $tran_id);

            $msg = "Transaction is Cancelled";
                
            $options = $this->paymentStatusOptions('cancel', $msg, 'Payment Cancelled!');
            $options['booking_id'] = $order_detials->booking_id;

            return view('payment.status', $options);

        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            //echo "Transaction is already Successful";
            $msg = "Transaction is already Successful";
            
            $options = $this->paymentStatusOptions('success', $msg, 'Thank You!');

            return view('payment.status', $options);

        } else {
            //echo "Transaction is Invalid";
            $msg = "Transaction is Invalid";

            $options = $this->paymentStatusOptions('error', $msg, 'Oops!');
            $options['booking_id'] = $order_detials->booking_id;

            return view('payment.status', $options);
        }
    }
}