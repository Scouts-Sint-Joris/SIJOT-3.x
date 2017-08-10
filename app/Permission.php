<?php

namespace Sijot;

/**
 * Class Permission
 *
 * @package Sijot
 */
class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Mass-assign fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'system_permission', 'name', 'description'];
}
