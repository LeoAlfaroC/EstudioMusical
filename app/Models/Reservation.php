<?php

namespace App\Models;

use App\Scopes\ReservationScope;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ReservationScope);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }

    public function details()
    {
        return $this->hasMany('App\Models\ReservationDetails');
    }
}
