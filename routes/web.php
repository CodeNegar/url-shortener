<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{url}/go', 'UrlController@show')->name('go');;

Route::get('/{url}/stats', 'UrlController@stats')->name('stats'); // todo: use view to show charts