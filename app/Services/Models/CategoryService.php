<?php

namespace App\Services\Models;

use App\Models\Category;
use Illuminate\Support\Arr;

class CategoryService
{
    /**
     * @param array $attributes
     *
     * @return Category
     */
    public function create(array $attributes): Category
    {
        $category = new Category();

        $fields = Arr::only($attributes, [
            'name',
            'description'
        ]);

        $category->fill($fields)->save();

        return $category;
    }

    /**
     * @param Category $category
     * @param array $attributes
     *
     * @return Category
     */
    public function update(Category $category, array $attributes): Category
    {
        $fields = Arr::only($attributes, [
            'name',
            'description'
        ]);

        $category->fill($fields)->save();

        return $category;
    }
}
