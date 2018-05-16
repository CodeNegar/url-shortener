<?php

namespace App\Listeners;

use App\Events\UrlWasVisited;
use App\Visit;
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
     * @return void
     */
    public function handle(UrlWasVisited $event)
    {
        // Update number of hits
        $event->url->increment('hits');

        // Save details of the visit
        $user_agent = $event->request->header('User-Agent');
        $dd = new DeviceDetector($user_agent);
        $dd->parse();

        $visit = new Visit;

        $visit->url_id = $event->url->id;
        $visit->os = trim($dd->getOs('name') . ' ' . $dd->getOs('version'));
        $visit->client_type = $dd->getClient('type');
        $visit->client_name = $dd->getClient('name');
        $visit->device = $dd->getDeviceName();
        $visit->referrer = $event->request->server('HTTP_REFERER');
        $visit->ip = $event->request->ip();
        $visit->country = ''; // todo: use a geo ip library
        $visit->user_agent = $user_agent;
        $visit->is_bot = $dd->isBot();

        $visit->save();
    }
}
