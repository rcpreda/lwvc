<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\EventBookingSchedule;

class Event extends Model
{
    use HasFactory;

    public function getUpdatedAtAttribute($value)
    {
        $updatedAt = new Carbon($value);
        return $updatedAt->format('d F Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventschedule()
    {
        return $this->hasOne(EventBookingSchedule::class,'event_id');
    }
}