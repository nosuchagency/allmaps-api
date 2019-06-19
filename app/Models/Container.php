<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Models\Content\Content;
use App\Pivots\BeaconContainer;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Container extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity, SoftCascadeTrait;

    /**
     * @var array
     */
    protected $softCascade = [
        'folders',
        'contents'
    ];

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
    public $relationships = [
        'tags',
        'folders',
        'folders.contents',
        'locations',
        'contents',
        'beacons'
    ];

    /**
     * Get the locations for the container
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the contents for the container through the folder
     */
    public function contents()
    {
        return $this->hasManyThrough(Content::class, Folder::class);
    }

    /**
     * The tags that belong to the container
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_container');
    }

    /**
     * Get the folders for the container
     */
    public function folders()
    {
        return $this->hasMany(Folder::class);
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
     * @param $type
     *
     * @return Skin
     */
    public function getSkin($type)
    {
        switch ($type) {
            case 'mobile' :
                return $this->mobileSkin;
            case 'tablet' :
                return $this->tabletSkin;
            case 'desktop' :
                return $this->desktopSkin;
            default :
                return $this->mobileSkin;
        }
    }

    /**
     * Get the mobile skin
     */
    public function mobileSkin()
    {
        return $this->belongsTo(Skin::class);
    }

    /**
     * Get the tablet skin
     */
    public function tabletSkin()
    {
        return $this->belongsTo(Skin::class);
    }

    /**
     * Get the desktop skin
     */
    public function desktopSkin()
    {
        return $this->belongsTo(Skin::class);
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
