<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Beacon;
use App\Models\Hit;
use App\Pivots\BeaconContainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HitService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $hit = new Hit();

        $hit->hittable()->associate(
            $this->getModel($request->get('type'), $request->input('model.id'))
        );
        $hit->fill($request->only($hit->getFillable()))->save();

        return $hit->refresh();
    }

    /**
     * @param Model $hit
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $hit, Request $request)
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
