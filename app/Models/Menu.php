<?php

namespace App\Models;

use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasRelations, SoftDeletes, SoftCascadeTrait;

    /**
     * @var array
     */
    protected $softCascade = [
        'items'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
        'items'
    ];

    /**
     * Get the menu items for the menu
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class)
            ->orderBy('order');
    }
}
