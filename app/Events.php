<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Events
 *
 * @package Sijot
 */
class Events extends Model
{
    // TODO: Set the date mutators.

    /**
     * Mass-assign fields for the database.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'status', 'title', 'description', 'end_date', 'end_hour', 'start_date', 'start_hour'];

    /**
     * Get the author for the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
