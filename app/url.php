<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class url extends Model
{
    /**
     * ID field is not an auto increment int.
     */
    public $incrementing = false;

    protected $appends = ['short_url'];

    /**
     * List of allowed fields for filling.
     */
    protected $fillable = [
        'id',
        'url',
    ];

    /**
     * List of allowed fields for filling.
     */
    protected $hidden = [
        'id',
        'url',
        'updated_at',
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
    public function getShortUrlAttribute()
    {
        return route('go', $this->id);
    }
}
