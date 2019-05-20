<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Place extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity, HasImage, HasRelationships, SoftCascadeTrait;

    const IMAGE_DIRECTORY_PATH = '/uploads/places';

    /**
     * @var array
     */
    protected $softCascade = [
        'buildings'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'postcode',
        'city',
        'latitude',
        'longitude',
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
        'latitude' => 'float',
        'longitude' => 'float',
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
    public $relationships = [
        'tags',
        'buildings',
        'buildings.floors',
        'buildings.floors.locations',
        'buildings.floors.structures',
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
     * Get all of the locations for the place
     */
    public function locations()
    {
        return $this->hasManyDeep(Location::class, [Building::class, Floor::class]);
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
}
