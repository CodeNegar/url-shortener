<?php

namespace App\Listeners;

use App\Events\UrlWasVisited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStats
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
     * @param  UrlWasVisited  $event
     * @return void
     */
    public function handle(UrlWasVisited $event)
    {
        //
    }
}
