<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrepareShortenRequest;
use App\url;
use Illuminate\Http\Request;

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
        return [
            'message' => 'URL successfuly shortened.',
            'data'   => [
                'url' => 'http://short.com/abc/go',
                'stats' => 'http://short.com/abc/stats',
            ]
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\url  $url
     * @return \Illuminate\Http\Response
     */
    public function show(url $url)
    {
        //
    }

    /**
     * Show the stats for requested resource.
     *
     * @param  \App\url  $url
     * @return \Illuminate\Http\Response
     */
    public function stats(url $url)
    {
        //
    }
}
