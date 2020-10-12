<?php

namespace App\Listeners\SendEmail;

use App\Events\SendEmailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailListener
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
     * @param  SendEmailEvent  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        //
    }
}
