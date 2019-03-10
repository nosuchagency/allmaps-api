<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MapLocation extends Model
{
    use SoftDeletes, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'coordinates',
        'zoom_level_from',
        'zoom_level_to',
        'title',
        'subtitle',
        'description',
        'company',
        'address',
        'city',
        'postal_code',
        'phone',
        'email',
        'poi_id',
        'fixture_id',
        'beacon_id',
        'floor_id',
        'created_by'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'coordinates' => 'array',
    ];

    /**.
     * @param  $value
     *
     * @return void
     */
    public function setCoordinatesAttribute($value)
    {
        $this->attributes['coordinates'] = json_encode($value);
    }

    /**
     * Get the floor that owns the Location.
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * Get the poi that owns the Location.
     */
    public function poi()
    {
        return $this->belongsTo(Poi::class);
    }

    /**
     * Get the fixture that owns the Location.
     */
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    /**
     * Get the beacon that owns the Location.
     */
    public function beacon()
    {
        return $this->belongsTo(Beacon::class);
    }

    public function getType()
    {
        if ($this->poi_id) {
            return 'poi';
        } else if ($this->fixture_id) {
            return 'fixture';
        } else if ($this->beacon_id) {
            return 'beacon';
        }

        return null;
    }

}
