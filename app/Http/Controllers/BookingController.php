<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Seat;

class BookingController extends Controller
{
    public function store()
    {
        $attributes = $this->validateRequest();

        $attributes['amount'] = $attributes['total_fare'];        
        unset($attributes['total_fare']);
        
        $booking = $this->createBooking($attributes);

        return $this->createSeatsFor($booking, $attributes);
    }   


    public function createBooking($attributes)
    {
        unset($attributes['selected_seats']);
        
        return auth()->user()->bookings()->create($attributes);
    }


    public function createSeatsFor($booking, $attributes)
    {
        extract($attributes);

        $seatNo = '';        

        foreach ($selected_seats as $seat ) {

            $seatNo = $seatNo .' '. $seat['seat_no'];            
            $booking->seats()->create($seat);
            
            //broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
        }

        $seats = trim($seatNo);
        $attributes['seats'] = $seats;
        unset($attributes['selected_seats']); 

        return response()->json($attributes);
    }


    protected function validateRequest()
    {
        return request()->validate([
            'bus_id' => 'required',          
            'schedule_id' => 'required',          
            'total_seats' => 'required',
            'date' => 'required',
            'pickup_point' =>'required',
            'dropping_point' => 'required',
            'total_fare' => 'required',
            'selected_seats' => 'required'
        ]);
    }


    public function destroy(Booking $booking)
    {
        //dd(auth()->user()->authorizeRoles(['super_admin', 'admin']));

        // if (! auth()->user()->authorizeRoles(['super_admin', 'admin'])) {
        //     //dd('here');
        //     $this->authorize('delete', $booking);
        // }
        $this->authorize('delete', $booking);
       //$bookingId = $booking->id;
       $scheduleId = $booking->schedule_id;        
       $travelDate = $booking->date;
       //$travelDate = date("d-m-Y", strtotime($booking->date)) ;
       $this->removeSeatBookedOrBuyingStatus($booking, $scheduleId, $travelDate);
        return redirect('/home');
    }

    public function removeSeatBookedOrBuyingStatus($booking, $scheduleId, $travelDate)
    {
        // by Deleting from bookings, seats table

        //Booking::destroy($bookingId); // deleting by pk

        //$seats = Seat::where('booking_id', $bookingId)->get();            
        $seats = $booking->load('seats');

        $booking->delete();

        foreach ($seats as $seat) {
            $updateSeatInfo = [
                    'seat_no' => $seat['seat_no'],
                    'status' => 'available',
            ];            
            $updateSeatInfo = json_decode(json_encode($updateSeatInfo)); //array to object
            //broadcast(new SeatStatusUpdatedEvent($updateSeatInfo, $scheduleId, $travelDate))->toOthers();
        }
        return;
    }

}
