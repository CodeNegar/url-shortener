<?php

namespace App\Http\Controllers;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return [
            'status' => 'success',
            'data'   => [
                'url' => 'http://short.com/abc/go',
                'stats' => 'http://short.com/abc/stats',
                'message' => 'URL successfuly shortened.'
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
