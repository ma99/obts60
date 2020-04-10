<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\SeatStatusUpdated;
use App\Schedule;
use App\Booking;
use App\Seat;
use App\Bus;
use App\User;

class BookingController extends Controller
{
    public function store(Request $request)
    {   
        // $booking = $this->createBooking($attributes);
        $attributes = $this->validateRequest();             
        $user = auth()->user();

        // $booking = $this->createBooking($user, $attributes);     
        // $attributes['booking_ref'] = $booking->id;
        // $attributes= $this->createSeatsFor($booking, $attributes);
        // return $this->bookedSeatInfo($attributes);        
        return $bookedSeatInfo = $this->seatBooking($user, $attributes);
    }   

    public function createByStaff(Request $request, User $user=null)
    {        
        if ($user) 
        {             
            $attributes = $this->validateRequest();

        } else
        {
            $attributes = $this->validateRequest();
            $info =  $this->getUserInfoFrom($request);
            $info['password'] = Hash::make(Str::random(8));
            $user = auth()->user()->create($info);             
        }        
        
        // $booking = $this->creatBooking($user, $attributes);
        // $attributes['booking_ref'] = $booking->id;
        // $attributes= $this->createSeatsFor($booking, $attributes);
        // return $this->bookedSeatInfo($attributes);
           return $bookedSeatInfo = $this->seatBooking($user, $attributes);
    }

    public function getUserInfoFrom(Request $request)
    {
        return $request->validate([
                'name' => 'required',          
                'email' => 'nullable',          
                'phone' => 'required',    
        ]);    
    }

    public function seatBooking(User $user, array $attributes)
    {
        $booking = $this->createBooking($user, $attributes);     
        $attributes['booking_ref'] = $booking->id;
        $attributes= $this->createSeatsFor($booking, $attributes);
        return $this->bookedSeatInfo($attributes);        
    }

    public function createBooking(User $user, array $attributes)
    {
        unset($attributes['selected_seats']);
        //return auth()->user()->bookings()->create($attributes);
        return $user->bookings()->create($attributes);
    }

    public function createSeatsFor($booking, $attributes)
    {
        extract($attributes);

        $seatNo = '';        

        foreach ($selected_seats as $seat ) {

            $seatNo = $seatNo .' '. $seat['seat_no'];            
            //$booking->seats()->create($seat);
            $booking->seats()->create([
                'seat_no' => $seat['seat_no'],
                'status'  => $seat['status'],
                'special' => $seat['special'],
            ]);
            
            //broadcast(new SeatStatusUpdatedEvent($seat, $scheduleId, $travelDate))->toOthers();
            broadcast(new SeatStatusUpdated($seat, $schedule_id, $bus_id, $date))->toOthers();
        }

        $seats = trim($seatNo);
        $attributes['seats'] = $seats;        
        unset($attributes['selected_seats']); 

        //return response()->json($attributes);
        return $attributes;
    }

    public function bookedSeatInfo($attributes)
    {
        $schedule = Schedule::Find($attributes['schedule_id']);
        $bus = Bus::Find($attributes['bus_id']);

        $attributes['departure_time'] = $schedule->departure_time;
        $attributes['bus_no'] = $bus->number_plate;

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
            //'total_fare' => 'required',
            'amount' => 'required',
            'selected_seats' => 'required'
        ]);
    }

    // protected function validateRequestBy($user)
    // {
    //     if ($user == 'staff') {
    //         return request()->validate([
    //             'name' => 'required',          
    //             'email' => 'nullable',          
    //             'phone' => 'required',
    //             'bus_id' => 'required',          
    //             'schedule_id' => 'required',          
    //             'total_seats' => 'required',
    //             'date' => 'required',
    //             'pickup_point' =>'required',
    //             'dropping_point' => 'required',
    //             //'total_fare' => 'required',
    //             'amount' => 'required',
    //             'selected_seats' => 'required'
    //         ]);    
    //     }
    //     return request()->validate([
    //         'bus_id' => 'required',          
    //         'schedule_id' => 'required',          
    //         'total_seats' => 'required',
    //         'date' => 'required',
    //         'pickup_point' =>'required',
    //         'dropping_point' => 'required',
    //         //'total_fare' => 'required',
    //         'amount' => 'required',
    //         'selected_seats' => 'required'
    //     ]);
    // }

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
       $busId = $booking->bus_id;               
       $travelDate = $booking->date;
       //$travelDate = date("d-m-Y", strtotime($booking->date)) ;
       $this->removeSeatBookedOrBuyingStatus($booking, $scheduleId, $travelDate);
        return redirect('/home');
    }

    public function removeSeatBookedOrBuyingStatus($booking, $scheduleId, $busId, $travelDate)
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
            broadcast(new SeatStatusUpdated($updateSeatInfo, $scheduleId, $busId, $travelDate))->toOthers();
        }
        return;
    }
}
