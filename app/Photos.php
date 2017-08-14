<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Photos
 *
 * @todo: Complete class documentation block. 
 * @package Sijot
 */
class Photos extends Model
{
    /**
     * Mass-assign fields for thue database table.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'title', 'image_path', 'url', 'description'];

    /**
     * Get the group form the photo album through a relation. 
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function group()
    {
        return $this->belongsToMany(Groups::class)->withTimestamps(); 
    }

    /**
     * Author data relation. 

     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');    
    }
}
