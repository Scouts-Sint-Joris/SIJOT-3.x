<?php

namespace Sijot;

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
    protected $fillable = ['author_id', 'publish', 'title', 'message'];

    /**
     * Get the author for the nezws article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Ctageories belongsToMany relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Categories::class)->withTimestamps();
    }
}
