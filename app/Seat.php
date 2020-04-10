<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\SeatStatusUpdated;

class Seat extends Model
{
    protected $guarded = [];

    protected $casts = [
        'special' => 'boolean',
    ];
    
    public function booking()
    {
    	return $this->belongsTo(Booking::class);
    }

    public function updateSeatStatus(array $bookingInfo)
    {	
    	extract($bookingInfo);
        $seats = Seat::where('booking_id', $booking_id)->get();            
            foreach ($seats as $seat) {
                $seat->update([
                        'status' => 'confirmed',
                    ]);
                broadcast(new SeatStatusUpdated($seat, $schedule_id, $bus_id, $travel_date))->toOthers();
            }
        return;
    }
}
