<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{url}/go', 'UrlController@show')->name('go');;

Route::get('/{url}/stats', function () {
    return view('stats');
})->name('stats');