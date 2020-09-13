<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public function student() {
        return $this->belongsTo('\App\Student');
    }

    public function classroom() {
        return $this->belongsTo('\App\Classroom');
    }
}
