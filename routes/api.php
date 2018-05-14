<?php

use Illuminate\Http\Request;

Route::get('/test', function(){
    return [
        'status' => 'success',
        'data'   => 'API is working correctly'
    ];
});
