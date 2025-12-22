<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Route extends Model
{
    protected $fillable = ['origin', 'destination'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
