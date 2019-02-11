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
        'poi_id',
        'findable_id',
        'floor_id',
        'type',
        'lat',
        'lng',
        'area',
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
     * Set the location's area
     *
     * @param  string $area
     *
     * @return void
     */
    public function setAreaAttribute($area)
    {
        $this->attributes['area'] = json_encode($area);
    }

    /**
     * Get the area
     *
     * @param  string $area
     *
     * @return string
     */
    public function getAreaAttribute($area)
    {
        return json_decode($area);
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
     * Get the findable that owns the Location.
     */
    public function findable()
    {
        return $this->belongsTo(Findable::class);
    }

}
