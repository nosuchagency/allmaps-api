<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapComponentField extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifier',
        'value',
        'map_location_id',
        'searchable_id'
    ];

    /**
     * Get the map location that owns the field
     */
    public function mapLocation()
    {
        return $this->belongsTo(MapLocation::class);
    }

    /**
     * Get the searchable that owns the field
     */
    public function searchable()
    {
        return $this->belongsTo(Searchable::class);
    }

}
