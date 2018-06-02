<?php

namespace App\Http\Controllers;

use App\Events\UrlWasCreated;
use App\Events\UrlWasVisited;
use App\Http\Requests\PrepareShortenRequest;
use App\Option;
use App\Url;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // todo: cache the results
        $urls = Url::take(10)->get(['id', 'hits', 'title', 'created_at']);

        return $urls;
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
        $url->id = $this->get_next_id();
        $url->url = $request->longurl;
        $url->save();

        event(new UrlWasCreated($url));

        return [
            'message' => 'URL successfuly shortened.',
            'data'   => [
                'short_url' => $url->short_url,
                'stats' => route('stats', $url->id)
            ]
        ];
    }

    /**
     * Redirect to the specified resource.
     *
     * @param  \App\Url  $url
     * @return \Illuminate\Http\Response
     */
    public function go(Url $url, Request $request)
    {
        event(new UrlWasVisited($url, $request));
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
        // todo: cache results and create rollup tables
        $periods = [
            'day' => Carbon::now()->startOfDay(),
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'all' => Carbon::now()->startOfCentury(),
        ];

        $metrics = [
            'os',
            'client_type',
            'client_name',
            'device',
            'referrer',
            'country',
            'is_bot'
        ];

        $stats = [];

        // Count visits for each period
        foreach ($periods as $period_name => $period_value) {
            $hits = $url->visits()
                ->where('created_at', '>=', $period_value)
                ->count();

            $stats[$period_name]['hits'] = $hits;
        }

        foreach ($metrics as $metric) {
            foreach ($periods as $period_name => $period_value) {
                $metric_rows = $url->visits()
                    ->groupBy([$metric])
                    ->orderBy('count', 'desc')
                    ->take(10)
                    ->where('created_at', '>=', $period_value)
                    ->get([$metric, DB::raw("count(*) as count")]);
                $os_list = [];
                foreach ($metric_rows as $metric_row) {
                    $key = empty($metric_row[$metric]) ? 'unknown' : $metric_row[$metric];
                    $value = (int) $metric_row['count'];
                    $os_list[$key] = $value;
                }

                $stats[$period_name][$metric] = $os_list;
            }
        }

        return $stats;
    }

    public function get_next_id($num = null) {
        $chars = env('URL_SHORTENER_CHARS', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $min_id = env('URL_SHORTENER_ID_MIN', 0);
        $step = env('URL_SHORTENER_ID_STEP', 1);

        if ($num == null || intval($num) <= 0) {
            $last_id = Option::where('key', 'last_id')->first();
            if($last_id == null){
                $last_id = new Option([
                    'key' => 'last_id',
                    'value' => '0'
                ]);
            }
            $num = $last_id->value ?? 0;
            $num += max($step, 1);
            $num = max($num, $min_id);
            $last_id->value = $num;
            $last_id->save();
        }

        $base = strlen($chars);

        $out = "";
        for ( $t = floor( log10( $num ) / log10( $base ) ); $t >= 0; $t-- ) {
            $a = floor( $num / pow( $base, $t ) );
            $out = $out . substr( $chars, $a, 1 );
            $num = $num - ( $a * pow( $base, $t ) );
        }

        return $out;
    }
}
