<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Groups
 *
 * @package App
 */
class Groups extends Model
{
    /**
     * Mass-assign fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['selector', 'title', 'sub_title', 'description'];

    /**
     * The scope used for getting groups.
     *
     * @param mixed  $query    The query builder instance.
     * @param string $selector The where criteria
     * 
     * @return mixed
     */
    public function scopeGetGroup($query, $selector)
    {
        return $query->where('selector', $selector)->first();
    }
}
