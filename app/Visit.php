<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    /**
     * Get the url that owns the visit.
     */
    public function url()
    {
        return $this->belongsTo('App\Url');
    }
}
