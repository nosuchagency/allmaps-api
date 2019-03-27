<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Floor extends Model
{
    use HasRelations, SoftDeletes, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'level',
        'building_id',
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
     * Model Relations
     *
     * @var array
     */
    public $relationships = [
        'structures',
        'locations'
    ];

    /**
     * Get the building that owns the floor
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the map structures of the floor
     */
    public function structures()
    {
        return $this->hasMany(MapStructure::class);
    }

    /**
     * Get the locations of the floor
     */
    public function locations()
    {
        return $this->hasMany(MapLocation::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($floor) {
            $floor->locations->each(function ($location) {
                $location->delete();
            });
        });

        static::restoring(function ($floor) {
            $floor->locations->each(function ($location) {
                $location->restore();
            });
        });
    }
}
