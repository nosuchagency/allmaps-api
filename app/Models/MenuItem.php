<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'order',
        'shown'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'shown' => 'boolean',
    ];

    /**
     * Get the menu that owns the menu item
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get all of the owning menuable models.
     */
    public function menuable()
    {
        return $this->morphTo();
    }

}
