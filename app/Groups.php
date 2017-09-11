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
}
