<?php

namespace App\Listeners;

use App\Events\UrlWasCreated;
use DOMDocument;
use DOMXPath;

class UpdateUrlDetails
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
     * @param UrlWasCreated $event
     *
     * @return void
     */
    public function handle(UrlWasCreated $event)
    {
        // todo: queue the event to speedup url shortening
        // todo: take proper action when the remote doc is not html or it's large
        $long_url = $event->url->url;
        $title = 'New url '.$event->url->id;

        try {
            $doc = new DOMDocument();
            $contents = $this->get_url($long_url);
            $doc->loadHTML($contents);
            $xpath = new DOMXPath($doc);
            $title = $xpath->query('//title')->item(0)->nodeValue;
        } catch (\Exception $e) {
            $url = $long_url;
            $path = parse_url($url, PHP_URL_PATH);
            $title = basename($path);
        }

        $event->url->title = $title;
        $event->url->save();
    }

    public function get_url($url)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        $remote_doc = $res->getBody();

        return 'here:'.$remote_doc;
    }
}
