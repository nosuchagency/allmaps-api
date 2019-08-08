<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MenuService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $menu = new Menu();
        $menu->fill($request->only($menu->getFillable()))->save();
        return $menu->refresh();
    }

    /**
     * @param Model $menu
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $menu, Request $request)
    {
        $menu->fill($request->only($menu->getFillable()))->save();
        return $menu->refresh();
    }
}