<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Location;
use App\Models\MenuItem;
use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MenuItemService
{
    /**
     * @param Request $request
     *
     * @return MenuItem
     */
    public function create(Request $request): MenuItem
    {
        $menuItem = new MenuItem();

        $menuItem->menuable()->associate(
            $this->getModel($request->get('type'), $request->input('model.id'))
        );

        $menuId = $request->input('menu.id');

        $menuItem->menu()->associate($menuId);

        if (is_null($menuItem->order)) {
            $menuItem->order = $this->getNextOrder($menuId);
        }

        $menuItem->fill($request->only($menuItem->getFillable()))->save();

        return $menuItem->refresh();
    }

    /**
     * @param MenuItem $menuItem
     * @param Request $request
     *
     * @return MenuItem
     */
    public function update(MenuItem $menuItem, Request $request): MenuItem
    {
        $menuItem->menuable()->associate(
            $this->getModel($request->get('type'), $request->input('model.id'))
        );

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

    /**
     * @param $type
     * @param $id
     *
     * @return Model|null
     */
    protected function getModel($type, $id)
    {
        switch ($type) {
            case 'poi':
                return Poi::find($id);
            case 'location':
                return Location::find($id);
            case 'tag':
                return Tag::find($id);
            case 'category':
                return Category::find($id);
            default :
                return null;
        }
    }
}
