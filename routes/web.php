<?php

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/{url}/go', 'UrlController@go')->name('go');

Route::get('/{url}/stats', 'UrlController@stats')->name('stats'); // todo: use view to show charts
