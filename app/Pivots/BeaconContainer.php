<?php

namespace App\Pivots;

use App\Models\Rule;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BeaconContainer extends Pivot
{
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
     * Get the rules for the beacon container
     */
    public function rules()
    {
        return $this->hasMany(Rule::class, 'beacon_container_id');
    }
}
