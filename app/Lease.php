<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lease
 *
 * @package App
 */
class Lease extends Model
{
    use SoftDeletes;

    /**
     * Mass-assign fields for the database table.
     *
     * @var array
     */
    protected $fillable = ['eind_datum', 'start_datum', 'status_id', 'contact_email', 'groeps_naam', 'tel_nummer'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['eind_datum', 'start_datum'];
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
        return $this->attributes['start_datum'] = strtotime(str_replace('/', '-', $date));
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
        return $this->attributes['eind_datum'] = strtotime(str_replace('/', '-', $date));
    }
}
