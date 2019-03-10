<?php

namespace App\Models;

use App\Pivots\BeaconContainer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Rule extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'distance',
        'weekday',
        'time_from',
        'time_to',
        'date_from',
        'date_to',
        'time_restricted',
        'date_restricted',
        'beacon_container_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'time_restricted' => 'boolean',
        'date_restricted' => 'boolean',
    ];

    /**
     * Get time from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getTimeFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set the date from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setTimeFromAttribute($value)
    {
        if ($value) {
            $this->attributes['time_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['time_from'] = null;
        }
    }

    /**
     * Get time to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getTimeToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set the date from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setTimeToAttribute($value)
    {
        if ($value) {
            $this->attributes['time_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['time_to'] = null;
        }
    }

    /**
     * Set the date from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setDateFromAttribute($value)
    {
        if ($value) {
            $this->attributes['date_from'] = Carbon::parse($value)->format('Y-m-d');
        } else {
            $this->attributes['date_from'] = null;
        }
    }

    /**
     * Set the date to
     *
     * @param  string $value
     *
     * @return void
     */
    public function setDateToAttribute($value)
    {
        if ($value) {
            $this->attributes['date_to'] = Carbon::parse($value)->format('Y-m-d');
        } else {
            $this->attributes['date_to'] = null;
        }
    }

    /**
     * Get beacon container that owns the rule
     */
    public function beaconContainer()
    {
        return $this->belongsTo(BeaconContainer::class);
    }
}
