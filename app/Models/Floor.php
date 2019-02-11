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
        'floor_plan',
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
    public $relations = [
        'structures',
        'pois',
        'findables',
        'beacons'
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
     * Get the pois of the floor
     */
    public function pois()
    {
        return $this->hasMany(MapLocation::class)
            ->whereNotNull('poi_id');
    }

    /**
     * Get the findables of the floor
     */
    public function findables()
    {
        return $this->hasMany(MapLocation::class)
            ->whereNotNull('findable_id');
    }

    /**
     * Get the beacons of the floor
     */
    public function beacons()
    {
        return $this->hasMany(Beacon::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($floor) {
            $floor->pois->each(function ($poi) {
                $poi->delete();
            });
            $floor->findables->each(function ($findable) {
                $findable->delete();
            });
            $floor->beacons->each(function ($beacon) {
                $beacon->delete();
            });
        });

        static::restoring(function ($floor) {
            $floor->pois->each(function ($poi) {
                $poi->restore();
            });
            $floor->findables->each(function ($findable) {
                $findable->restore();
            });
            $floor->beacons->each(function ($beacon) {
                $beacon->restore();
            });
        });
    }
}
