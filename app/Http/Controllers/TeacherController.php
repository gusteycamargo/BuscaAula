<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

class TeacherController extends Controller
{
    public function __construct() {
        $this->middleware('auth:teacher');
    }

    public function home() {
        return view('main.main-teacher');
    }
}
