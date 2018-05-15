<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{url}/go', 'UrlController@show');
Route::get('/{url}/stats', 'UrlController@show');