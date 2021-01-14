<?php

namespace App\Listeners;

use App\Events\NewUserHasRegisteredEvent;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class WelcomeNewUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewUserHasRegisteredEvent $event)
    {
        Mail::to($event->user->email)->send(new WelcomeNewUserMail($event->user));
    }
}
