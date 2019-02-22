<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Place extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity, HasImage;

    const IMAGE_DIRECTORY_PATH = '/uploads/places';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'zipcode',
        'city',
        'lat',
        'lng',
        'category_id',
        'created_by',
        'category',
        'activated'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'activated' => 'boolean'
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
        'tags',
        'buildings',
        'buildings.floors',
        'buildings.floors.locations'
    ];

    /**
     * The tags that belong to the place
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_place');
    }

    /**
     * Get the buildings for the place
     */
    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    /**
     * Process filters
     *
     * @param Builder $builder
     * @param $request
     *
     * @return Builder $builder
     */
    public function scopeFilter(Builder $builder, $request)
    {
        return (new IndexFilter($request))->filter($builder);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($place) {
            $place->buildings->each(function ($building) {
                $building->delete();
            });
        });
        static::restoring(function ($place) {
            $place->buildings->each(function ($building) {
                $building->restore();
            });
        });
    }

}
