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

class Poi extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, HasImage, LogsActivity;

    const IMAGE_DIRECTORY_PATH = '/uploads/pois';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'type',
        'color',
        'category_id',
        'created_by',
        'category'
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
        'locations'
    ];

    /**
     * The tags that belong to the poi
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_poi');
    }

    /**
     * Get the locations for the Poi.
     */
    public function locations()
    {
        return $this->hasMany(MapLocation::class);
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

        static::deleting(function ($poi) {
            $poi->locations->each(function ($location) {
                $location->delete();
            });
        });

        static::restoring(function ($poi) {
            $poi->locations->each(function ($location) {
                $location->restore();
            });
        });
    }
}
