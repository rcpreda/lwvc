<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class EventBookingSchedule extends Model
{
    use HasFactory;
    //protected $table='event_booking_schedules';
    protected $table = 'event_booking_schedules';

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
