<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }
}
