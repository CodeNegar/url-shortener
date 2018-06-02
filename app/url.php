<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    /**
     * ID field is not an auto increment int
     */
    public $incrementing = false;

    /**
     * List of allowed fields for filling
     */
    protected $fillable = [
        'id',
        'url'
    ];

    /**
     * Get the visits for the current url.
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    /**
     * Set the short_url mutator field.
     *
     * @return void
     */
    public function getShort_UrlAttribute()
    {
        $this->attributes['short_url'] = route('go', $this->id);
    }
}
