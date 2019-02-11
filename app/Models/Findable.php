<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Findable extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_by',
        'category_id',
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
     * The tags that belong to the findable
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_findable');
    }

    /**
     * Get the locations for the Findable.
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

        static::deleting(function ($findable) {
            $findable->locations->each(function ($location) {
                $location->delete();
            });
        });
        static::restoring(function ($findable) {
            $findable->locations->each(function ($location) {
                $location->restore();
            });
        });
    }
}
