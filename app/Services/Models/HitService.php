<?php

namespace App\Services\Models;

use App\Models\Hit;
use App\Pivots\BeaconContainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class HitService
{
    /**
     * @param array $attributes
     *
     * @return Hit
     */
    public function create(array $attributes): Hit
    {
        $hit = new Hit();

        $hit->hittable()->associate(
            $this->getModel(Arr::get($attributes, 'type'), Arr::get($attributes, 'model.id'))
        );

        $hit->save();

        return $hit->refresh();
    }

    /**
     * @param Hit $hit
     * @param array $attributes
     *
     * @return Hit
     */
    public function update(Hit $hit, array $attributes): Hit
    {
        $fields = Arr::only($attributes, [

        ]);

        $hit->fill($fields)->save();

        if (Arr::has($attributes, 'model')) {
            $hit->hittable()->associate(
                $this->getModel(Arr::get($attributes, 'type'), Arr::get($attributes, 'model.id'))
            );
        }

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
