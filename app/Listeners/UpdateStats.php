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
        // todo: queue the event to speedup redirecting
        // Update number of hits
        $event->url->increment('hits');

        // Save details of the visit
        $user_agent = $event->request->header('User-Agent');
        $ip = $this->get_real_ip() ?? $event->request->ip();
        $geo_data = geoip($ip);
        $country = $geo_data->country ?? '';
        $dd = new DeviceDetector($user_agent);
        $dd->parse();

        $visit = new Visit;

        $visit->url_id = $event->url->id;
        $visit->os = trim($dd->getOs('name') . ' ' . $dd->getOs('version'));
        $visit->client_type = $dd->getClient('type');
        $visit->client_name = $dd->getClient('name');
        $visit->device = $dd->getDeviceName();
        $visit->referrer = $event->request->server('HTTP_REFERER');
        $visit->ip = $ip;
        $visit->country = $country;
        $visit->user_agent = $user_agent;
        $visit->is_bot = $dd->isBot();

        $visit->save();
    }

    protected function get_real_ip(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
}
