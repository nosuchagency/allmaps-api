<?php

namespace App\Services\Models;

use App\Models\Menu;
use Illuminate\Support\Arr;

class MenuService
{
    /**
     * @param array $attributes
     *
     * @return Menu
     */
    public function create(array $attributes): Menu
    {
        $menu = new Menu();

        $fields = Arr::only($attributes, [
            'name',
        ]);

        $menu->fill($fields)->save();

        return $menu->refresh();
    }

    /**
     * @param Menu $menu
     * @param array $attributes
     *
     * @return Menu
     */
    public function update(Menu $menu, array $attributes): Menu
    {
        $fields = Arr::only($attributes, [
            'name',
        ]);

        $menu->fill($fields)->save();

        return $menu->refresh();
    }
}
