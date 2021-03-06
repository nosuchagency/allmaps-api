<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * AbstractFilter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filter(Builder $builder)
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value);
        }
        return $builder;
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }

    /**
     * @param string $filter
     *
     * @return mixed
     */
    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }
}
