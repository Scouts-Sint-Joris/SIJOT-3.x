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
    // TODO Complete class docblock. 
    
    /**
     * Mass-assign fielpds for the database.
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

    /**
     * Get the news through the data relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function news()
    {
        return $this->belongsToMany(News::class)->withTimestamps();
    }
}
