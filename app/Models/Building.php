<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Building extends Model
{
    use HasRelations, SoftDeletes, HasCreatedBy, LogsActivity, HasImage;

    const IMAGE_DIRECTORY_PATH = '/uploads/buildings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'place_id',
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
        'floors',
        'floors.locations'
    ];

    /**
     * Get the place that owns the building
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the floors for the building
     */
    public function floors()
    {
        return $this->hasMany(Floor::class)
            ->orderBy('level');
    }

    /**
     * Get all of the locations for the building
     */
    public function locations()
    {
        return $this->hasManyThrough(MapLocation::class, Floor::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($building) {
            $building->floors->each(function ($floor) {
                $floor->delete();
            });
        });
        static::restoring(function ($building) {
            $building->floors->each(function ($floor) {
                $floor->restore();
            });
        });
    }
}
