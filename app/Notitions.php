<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notitions
 * ss
 * @package Sijot
 */
class Notitions extends Model
{
    /**
     * Mass-assgin fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'text'];

    /**
     * Get the author information for the notition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
