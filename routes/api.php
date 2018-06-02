<?php

// Get list of latest short URLs
Route::get('/urls', 'UrlController@index');

// Create a new short URL
Route::post('/urls', 'UrlController@store');

// Get stats of a specific short URL
Route::get('/urls/{url}/stats', 'UrlController@stats');

// Get details of a specific short URL
Route::get('/urls/{url}', 'UrlController@show');

// Health check
Route::get('/test', function(){
    return [
        'status'   => 'success',
        'data'     => 'API is working correctly'
    ];
});
