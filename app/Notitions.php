<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notitions
 *
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

    /**
     * Get the lease for the notition. Through the relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lease()
    {
        return $this->belongsToMany(Lease::class)->withTimestamps();
    }
}
