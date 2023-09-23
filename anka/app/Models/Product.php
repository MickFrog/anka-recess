<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
