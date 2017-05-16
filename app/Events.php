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
    /**
     * Mass-assign fields for the database.
     *
     * @var array
     */
    protected $fillable = ['author_id', 'status', 'title', 'description', 'end_date', 'end_hour', 'start_date', 'start_hour'];

    /**
     * The attributes that should mutated to dates.
     *
     * @var array
     */
    protected $dates = ['end_date', 'end_hour', 'start_date', 'start_hour'];

    /**
     * Get the author for the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Format the timestamp format.
     *
     * @param  string $date The start time from the form
     * @return string
     */
    public function setEndDateAttribute($date)
    {
        // Use with Carbon instance:
        // -------
        // Carbon::createFromFormat('H:i', $date)->format('H:i');
        return $this->attributes['end_date'] = strtotime(str_replace('/', '-', $date));
    }

    /**
     * Format the timestamp format.
     *
     * @param  string $date The start time from the form
     * @return string
     */
    public function setEndHourAttribute($date)
    {
        // Use with Carbon instance:
        // -------
        // Carbon::createFromFormat('H:i', $date)->format('H:i');
        return $this->attributes['end_hour'] = strtotime(str_replace('/', '-', $date));
    }


    /**
     * Format the timestamp format.
     *
     * @param  string $date The start time from the form
     * @return string
     */
    public function setStartDateAttribute($date)
    {
        // Use with Carbon instance:
        // -------
        // Carbon::createFromFormat('H:i', $date)->format('H:i');
        return $this->attributes['start_date'] = strtotime(str_replace('/', '-', $date));
    }

    /**
     * Format the timestamp format.
     *
     * @param  string $date The start time from the form
     * @return string
     */
    public function setStartHourAttribute($date)
    {
        // Use with Carbon instance:
        // -------
        // Carbon::createFromFormat('H:i', $date)->format('H:i');
        return $this->attributes['start_hour'] = strtotime(str_replace('/', '-', $date));
    }
}
