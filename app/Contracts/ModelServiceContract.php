<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function create(Request $request);

    /**
     * @param Model $model
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Model $model, Request $request);
}