<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;

class Slotbooking extends Model
{
    use HasFactory;
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
