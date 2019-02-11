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

class Beacon extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'proximity_uuid',
        'major',
        'minor',
        'eddystone_uid',
        'eddystone_url',
        'eddystone_tlm',
        'eddystone_eid',
        'lat',
        'lng',
        'floor_id',
        'category_id',
        'category',
        'created_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
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
        'containers'
    ];

    /**
     * Get the floor that owns the beacon
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * The tags that belong to the beacon
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_beacon');
    }

    /**
     * The content containers that belong to the user.
     */
    public function containers()
    {
        return $this->belongsToMany(Container::class)
            ->using(BeaconContainer::class)->withPivot(['id']);
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
