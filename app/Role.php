<?php

namespace Sijot;

/**
 * Class Role
 *
 * @package Sijot
 */
class Role extends \Spatie\Permission\Models\Role
{
    /**
     * Mass-assign fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'system_role', 'name', 'description'];
}
