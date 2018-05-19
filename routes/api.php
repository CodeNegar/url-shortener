<?php

use Illuminate\Http\Request;

Route::get('/index', 'UrlController@index');
Route::post('/store', 'UrlController@store');
Route::get('/{url}/stats', 'UrlController@stats');
Route::get('/test', function(){
    return [
        'status'   => 'success',
        'data'     => 'API is working correctly'
    ];
});
