<?php

namespace App\Models;

use App\Filters\SearchFilter;
use App\Traits\HasCreatedBy;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class Token extends Model implements AuthorizableContract
{
    use HasRoles, Authorizable, HasCreatedBy, CausesActivity, LogsActivity;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_by'
    ];


    /**
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function recentActions($count = 20)
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


    /**
     * @return void
     */
    public function generateToken()
    {
        $this->token = Str::random(60);
    }
}
