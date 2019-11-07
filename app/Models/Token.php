<?php

namespace App\Models;

use App\Filters\SearchFilter;
use App\Traits\HasCreatedBy;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Token extends Model implements AuthorizableContract
{
    use Authorizable, HasCreatedBy, CausesActivity, LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the role of the token
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|Collection
     */
    public function recentActivities($count = 20)
    {
        return $this->actions()->orderBy('id', 'desc')->take($count)->get();
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
        return (new SearchFilter($request))->filter($builder);
    }
}
