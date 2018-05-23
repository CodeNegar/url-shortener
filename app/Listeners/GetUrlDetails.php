<?php

namespace App\Listeners;

use App\Events\UrlWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetUrlDetails
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
     * @param  UrlWasCreated  $event
     * @return void
     */
    public function handle(UrlWasCreated $event)
    {
        //
    }
}
