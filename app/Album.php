<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function photos() {
        return $this->hasMany('App\photo');
    }

    public function users() {
        return $this->belongsTo('App\User');
    }
}
