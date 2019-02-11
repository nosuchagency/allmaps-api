<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Models\Content\Content;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Container extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity;

    protected $table = 'content_containers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'folders_enabled',
        'created_by',
        'category_id',
        'category'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'folders_enabled' => 'boolean'
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
        'folders',
        'folders.contents',
        'contents',
        'beacons'
    ];

    /**
     * The tags that belong to the container
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_container');
    }

    /**
     * Get the folders for the content.
     */
    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    /**
     * Get the contents for the content container.
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * The beacons that belong to the container.
     */
    public function beacons()
    {
        return $this->belongsToMany(Beacon::class)
            ->using(BeaconContainer::class)->withPivot(['id']);
    }

    /**
     * Get primary folder
     *
     * @return mixed
     */
    public function primaryFolder()
    {
        return $this->folders()->with('contents')->primary()->first();
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
