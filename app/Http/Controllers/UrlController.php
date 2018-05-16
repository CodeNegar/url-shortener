<?php

namespace App\Http\Controllers;

use App\Events\UrlWasVisited;
use App\Http\Requests\PrepareShortenRequest;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PrepareShortenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrepareShortenRequest $request)
    {
        $url = new Url();
        $url->url = $request->longurl;
        $url->save();

        return [
            'message' => 'URL successfuly shortened.',
            'data'   => [
                'url' => route('go', $url->id),
                'stats' => route('stats', $url->id)
            ]
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        event(new UrlWasVisited($url));
        return Redirect::away($url->url);
    }

    /**
     * Show the stats for requested resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function stats(Url $url)
    {
        //
    }
}
