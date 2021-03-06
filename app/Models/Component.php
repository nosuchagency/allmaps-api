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

class Component extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, HasImage, LogsActivity, SoftCascadeTrait;

    const IMAGE_DIRECTORY_PATH = 'uploads/components';

    /**
     * @var array
     */
    protected $softCascade = [
        'structures'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
        'category',
        'tags',
        'structures'
    ];

    /**
     * The tags that belong to the map component
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_component');
    }

    /**
     * Get the map structures of the floor
     */
    public function structures()
    {
        return $this->hasMany(Structure::class);
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
