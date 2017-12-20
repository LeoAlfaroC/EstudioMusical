<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function instruments()
    {
        return $this->hasMany('App\Models\Instrument');
    }
}
