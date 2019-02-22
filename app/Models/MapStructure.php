<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MapStructure extends Model
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
        'radius',
        'map_component_id',
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
     * Get the map component that owns the Location.
     */
    public function mapComponent()
    {
        return $this->belongsTo(MapComponent::class);
    }
}
