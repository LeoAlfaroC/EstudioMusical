<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    public function reservations()
    {
        return $this->hasMany('App\Models\ReservationDetails');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
