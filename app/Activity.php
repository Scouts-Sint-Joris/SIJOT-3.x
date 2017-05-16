<?php

namespace Sijot;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @package App
 */
class Activity extends Model
{
    /**
     * Mass-assign fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['group_id', 'status', 'title', 'activiteit_datum', 'start_hour', 'end_hour', 'description'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array
     */
    protected $dates = ['activiteit_datum', 'start_hour', 'end_hour'];

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
    public function setActiviteitDatumAttribute($date)
    {
        // Use with Carbon instance:
        // -------
        // Carbon::createFromFormat('H:i', $date)->format('H:i');
        return $this->attributes['activiteit_datum'] = strtotime(str_replace('/', '-', $date));
    }

    /**
     * Get the group for the activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }
}
