<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price_per_day'
    ];

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
