<?php

namespace App\Models;

use App\Plugins\Search\SearchableResolver;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Searchable extends Model
{
    use HasCreatedBy, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'identifier',
        'created_by',
        'activated'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'activated' => 'boolean',
    ];

    /**
     * Scope a query to only active searchables
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereActivated(true);
    }

    /**
     * @return object|null
     */
    public function getPlugin()
    {
        return (new SearchableResolver())->resolve($this->identifier);
    }

    /**
     * Get the fields
     */
    public function fields()
    {
        return $this->hasMany(MapLocationField::class);
    }
}
