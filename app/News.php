<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * @package App
 */
class News extends Model
{
    /**
     * Mass-assign fields for the database.
     *
     * @return array
     */
    protected $fillable = [];

    public function categories()
    {
        return $this->belongsToMany(Categories::class)->withTimestamps();
    }
}
