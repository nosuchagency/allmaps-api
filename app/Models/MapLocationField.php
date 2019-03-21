<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapLocationField extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'identifier',
        'type',
        'value',
        'map_location_id',
        'searchable_id'
    ];

    /**
     * Get the value attribute
     *
     * @param  $value
     *
     * @return mixed
     */
    public function getValueAttribute($value)
    {
        if ($this->type === 'boolean') {
            return (bool)$value;
        }

        return $value;
    }

    /**
     * Set the value attribute
     *
     * @param  $value
     *
     * @return void
     */
    public function setValueAttribute($value)
    {
        if ($this->type === 'boolean') {
            $this->attributes['value'] = (bool)$value;
        } else {
            $this->attributes['value'] = $value;
        }
    }

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
