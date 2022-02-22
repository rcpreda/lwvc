<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
}
