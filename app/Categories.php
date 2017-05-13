<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Categories
 *
 * @package App
 */
class Categories extends Model
{
    /**
     * Mass-aàssign fielpds for the database.
     *
     * @return array
     */
    protected $fillable = ['author_id', 'module', 'name', 'description'];

    /**
     * Get the user data for the creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
