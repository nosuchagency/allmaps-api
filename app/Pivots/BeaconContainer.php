<?php

namespace App\Pivots;

use App\Models\Hit;
use App\Models\Rule;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BeaconContainer extends Pivot
{

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'beacon_id',
        'container_id',
    ];

    /**
     * Get all the hits
     */
    public function hits()
    {
        return $this->morphMany(Hit::class, 'hittable');
    }

    /**
     * Get the rules for the beacon container
     */
    public function rules()
    {
        return $this->hasMany(Rule::class, 'beacon_container_id');
    }
}
