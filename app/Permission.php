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

    /**
     * Author data relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() 
    {
        return $this->belongsTo(User::class);
    }
}
