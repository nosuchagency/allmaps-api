<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;

class Template extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity;

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
        'activated' => 'boolean',
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
        'tags'
    ];

    /**
     * The tags that belong to the template
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_template');
    }

    /**
     * Get the layout that owns the template
     */
    public function layout()
    {
        return $this->belongsTo(Layout::class);
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
