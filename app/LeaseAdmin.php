<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

class LeaseAdmin extends Model
{
    // TODO: Implement class block. 
    /**
     * Mass-assign fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['persons_id', 'info'];

    /**
     * Connect the users data to the persons_id throught the id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function person()
    {
        return $this->belongsTo(User::class, 'persons_id');
    }
}
