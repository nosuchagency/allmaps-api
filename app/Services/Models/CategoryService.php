<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CategoryService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $category = new Category();
        $category->fill($request->only($category->getFillable()))->save();
        return $category->refresh();
    }

    /**
     * @param Model $category
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $category, Request $request)
    {
        $category->fill($request->only($category->getFillable()))->save();

        return $category->refresh();
    }
}