<?php

namespace App\Models;

use App\Filters\PoiFilter;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Poi extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, HasImage, LogsActivity, SoftCascadeTrait;

    const IMAGE_DIRECTORY_PATH = '/uploads/pois';

    /**
     * @var array
     */
    protected $softCascade = [
        'locations'
    ];

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
        'stroke',
        'stroke_type',
        'stroke_color',
        'stroke_width',
        'stroke_opacity',
        'fill',
        'fill_color',
        'fill_opacity',
        'category_id',
        'created_by',
        'category'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'stroke' => 'boolean',
        'stroke_opacity' => 'double',
        'fill' => 'boolean',
        'fill_opacity' => 'double',
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
        return $this->morphMany(Location::class, 'locatable');
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
        return (new PoiFilter($request))->filter($builder);
    }
}
