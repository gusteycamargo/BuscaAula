<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Student;
use App\Teacher;
use App\Classroom;

class NewRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Teacher $teacher, Student $student, Classroom $class)
    {
        $this->teacher = $teacher;
        $this->student = $student;
        $this->class = $class;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.new-register')->with(['teacher' => $this->teacher, 'student' => $this->student, 'class' => $this->class]);
    }
}
