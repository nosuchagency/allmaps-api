<?php

namespace App\Services\Models;

use App\Models\Hit;
use App\Pivots\BeaconContainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HitService
{
    /**
     * @param Request $request
     *
     * @return Hit
     */
    public function create(Request $request): Hit
    {
        $hit = new Hit();

        $hit->hittable()->associate(
            $this->getModel($request->get('type'), $request->input('model.id'))
        );

        $hit->save();

        return $hit->refresh();
    }

    /**
     * @param Hit $hit
     * @param Request $request
     *
     * @return Hit
     */
    public function update(Hit $hit, Request $request): Hit
    {
        $hit->fill($request->only($hit->getFillable()))->save();
        return $hit->refresh();
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
            case 'beacon_container':
                return BeaconContainer::find($id);
            default :
                return null;
        }
    }
}
