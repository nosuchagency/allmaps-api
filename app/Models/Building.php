<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Building extends Model
{
    use HasRelations, SoftDeletes, HasCreatedBy, LogsActivity, HasImage, SoftCascadeTrait;

    const IMAGE_DIRECTORY_PATH = '/uploads/buildings';

    /**
     * @var array
     */
    protected $softCascade = [
        'floors'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'created_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
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
        'floors',
        'floors.locations'
    ];

    /**
     * Get the place that owns the building
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the menu that owns the building
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the floors for the building
     */
    public function floors()
    {
        return $this->hasMany(Floor::class)
            ->orderBy('level');
    }

    /**
     * Get all of the locations for the building
     */
    public function locations()
    {
        return $this->hasManyThrough(Location::class, Floor::class);
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
