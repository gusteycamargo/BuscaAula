<?php

namespace App\Listeners;

use App\Events\RegistrationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewRegistered;
use Illuminate\Support\Facades\Mail;

class RegistrationEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationEvent  $event
     * @return void
     */
    public function handle(RegistrationEvent $event)
    {

        Mail::to($event->student->email)->send(
            new NewRegistered($event->teacher, $event->student, $event->class)
        );

        info($event->teacher->name);
        info($event->student->email);
        info($event->class->name);
    }
}
