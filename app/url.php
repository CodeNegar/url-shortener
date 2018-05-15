<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    /**
     * List of allowed fields for filling
     */
    protected $fillable = [
        'url'
    ];
}
