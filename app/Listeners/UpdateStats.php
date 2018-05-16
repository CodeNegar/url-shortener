<?php

namespace App\Listeners;

use App\Events\UrlWasVisited;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;

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
     * @param  Request  $request
     * @return void
     */
    public function handle(UrlWasVisited $event)
    {
        // Update number of hits
        $event->url->increment('hits');
    }
}
