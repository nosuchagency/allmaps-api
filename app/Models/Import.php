<?php

namespace App\Models;

use App\Filters\ImportFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'started_at',
        'finished_at',
        'status',
        'count'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'finished_at'
    ];

    /**
     * @param string $type
     *
     * @return void
     */
    public function start(string $type)
    {
        $this->fill([
            'type' => $type,
            'stated_at' => now()
        ])->save();
    }


    /**
     * @param bool $status
     * @param int $count
     *
     * @return void
     */
    public function finish($status = true, $count = 0)
    {
        $this->fill([
            'status' => $status,
            'count' => $count,
            'finished_at' => now()
        ])->save();
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
        return (new ImportFilter($request))->filter($builder);
    }
}
