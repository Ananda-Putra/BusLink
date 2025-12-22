<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['bus_name', 'total_seats'];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
