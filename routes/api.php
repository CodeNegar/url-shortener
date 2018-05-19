<?php

use Illuminate\Http\Request;

Route::get('/index', 'UrlController@index');
Route::post('/store', 'UrlController@store');
Route::get('/{url}/stats', 'UrlController@stats');
Route::get('/test', function(){
    var_dump(geoip('118.100.4.100')->country);
    return [
        'status' => 'success',
        'data'   => 'API is working correctly'
    ];
});
