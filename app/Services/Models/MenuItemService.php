<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Category;
use App\Models\Location;
use App\Models\MenuItem;
use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MenuItemService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $menuItem = new MenuItem();

        if ($request->filled('poi')) {
            $menuable = Poi::find($request->input('poi.id'));
        } else if ($request->filled('location')) {
            $menuable = Location::find($request->input('location.id'));
        } else if ($request->filled('tag')) {
            $menuable = Tag::find($request->input('tag.id'));
        } else if ($request->filled('category')) {
            $menuable = Category::find($request->input('category.id'));
        } else {
            $menuable = null;
        }

        $menuItem->menuable()->associate($menuable);

        $menuId = $request->input('menu.id');

        $menuItem->menu()->associate($menuId);

        if (is_null($menuItem->order)) {
            $menuItem->order = $this->getNextOrder($menuId);
        }

        $menuItem->fill($request->only($menuItem->getFillable()))->save();

        return $menuItem->refresh();
    }

    /**
     * @param Model $menuItem
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $menuItem, Request $request)
    {
        $menuable = null;

        if ($request->filled('poi')) {
            $menuable = Poi::find($request->input('poi.id'));
        } else if ($request->filled('location')) {
            $menuable = Location::find($request->input('location.id'));
        } else if ($request->filled('tag')) {
            $menuable = Tag::find($request->input('tag.id'));
        } else if ($request->filled('category')) {
            $menuable = Category::find($request->input('category.id'));
        }

        if ($menuable) {
            $menuItem->menuable()->associate($menuable);
        }

        $menuItem->fill($request->only($menuItem->getFillable()))->save();

        return $menuItem->refresh();
    }

    /**
     * @param $menuId
     *
     * @return int
     */
    protected function getNextOrder($menuId)
    {
        $currentOrder = MenuItem::whereMenuId($menuId)->max('order');

        if (is_null($currentOrder)) {
            return 0;
        }

        return ++$currentOrder;
    }
}