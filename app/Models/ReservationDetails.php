<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationDetails extends Model
{
    protected $table = 'reservation_details';

    public function parent()
    {
        return $this->belongsTo('App\Models\Reservation', 'reservation_id'); // Don't know why, but if I don't explicitly give the foreign key, querying it's parent won't work (will give null as parameter)
    }

    public function instruments()
    {
        return $this->belongsTo('App\Models\Instrument');
    }
}
