<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{
    protected $fillable = [
        'student_id', 'teacher_id'
    ];

    public function student() {
        return $this->belongsTo('\App\Student');
    }

    public function teacher() {
        return $this->belongsTo('\App\Teacher');
    }
}
