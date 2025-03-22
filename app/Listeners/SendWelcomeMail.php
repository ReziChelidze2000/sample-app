<?php

namespace App\Listeners;

use App\Events\RegisterUser;
use App\Mail\WelcomeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendWelcomeMail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterUser $event): void
    {
        Mail::to($event->user)->send(new WelcomeMail($event->user));
    }
}
