<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasRelations
{
    /**
     * Scope a query to only include popular users.
     *
     * @param Builder $query
     * @param Request $request
     *
     * @return Builder
     */
    public function scopeWithRelations(Builder $query, Request $request)
    {
        if ($relations = $request->get('include')) {
            $relations = explode(',', $relations);

            foreach ($relations as $relation) {
                if (in_array($relation, $this->relationships ?? [])) {
                    $query->with($relation);
                }
            }
        }

        return $query;
    }
}