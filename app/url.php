<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class url extends Model
{
    /**
     * List of allowed fields for filling
     */
    protected $fillable = [
        'url'
    ];
}
