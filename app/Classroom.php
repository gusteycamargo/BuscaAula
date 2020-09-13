<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    public function teacher() {
        return $this->belongsTo('\App\Teacher');
    }

    public function student() {
        return $this->belongsToMany('\App\Student', 'registrations');
    }
}
