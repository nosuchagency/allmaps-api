<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Floor extends Model
{
    use HasRelations, SoftDeletes, HasCreatedBy, LogsActivity, SoftCascadeTrait;

    /**
     * @var array
     */
    protected $softCascade = [
        'structures',
        'locations'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'level',
        'created_by'
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
        'structures',
        'locations'
    ];

    /**
     * Get the building that owns the floor
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the map structures of the floor
     */
    public function structures()
    {
        return $this->hasMany(Structure::class);
    }

    /**
     * Get the locations of the floor
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
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
