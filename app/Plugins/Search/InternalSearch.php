<?php

namespace App\Plugins\Search;

use App\Plugins\Contracts\Search;
use Illuminate\Database\Eloquent\Builder;

class InternalSearch implements Search
{
    /**
     * @var string
     */
    protected $table = 'map_locations.';

    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var array
     */
    protected $searchableFields = [
        'name',
        'type',
        'title',
        'subtitle',
        'description',
        'company',
        'address',
        'city',
        'postcode',
        'phone',
        'email'
    ];

    /**
     * @param $payload
     * @param Builder $builder
     *
     * @return SearchResults
     */
    public function search($payload, Builder $builder): SearchResults
    {
        $constraints = [];

        foreach ($payload['fields'] as $field) {
            if (in_array($field, $this->searchableFields)) {
                $constraints[$this->table . $field] = $payload['query'];
            }
        }

        return new SearchResults(
            $builder->where(function (Builder $query) use ($constraints) {
                $query->orWhere($constraints);
            })->get()
        );
    }
}