<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Models\Content\Content;
use App\Scopes\OrderScope;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Folder extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity, SoftCascadeTrait;

    /**
     * @var array
     */
    protected $softCascade = [
        'contents'
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
        'primary' => 'boolean'
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
        'contents',
        'container'
    ];

    /**
     * Get the container that owns the folder.
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    /**
     * The tags that belong to the folder
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_folder');
    }

    /**
     * Get the contents for the folder.
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePrimary($query)
    {
        return $query->where('primary', true);
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope());
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
