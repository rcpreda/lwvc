<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function getUpdatedAtAttribute($value)
    {
        $updatedAt = new Carbon($value);
        return $updatedAt->format('d F Y');
    }
}
