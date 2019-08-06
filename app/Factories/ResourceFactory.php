<?php

namespace App\Factories;

use App\Http\Resources\BuildingResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\FixtureResource;
use App\Http\Resources\FloorResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\PoiResource;
use App\Http\Resources\BeaconResource;
use App\Http\Resources\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;
use InvalidArgumentException;

class ResourceFactory
{
    /**
     * @var string
     */
    const POI = 'poi';

    /**
     * @var string
     */
    const BEACON = 'beacon';

    /**
     * @var string
     */
    const FIXTURE = 'fixture';

    /**
     * @var string
     */
    const BUILDING = 'building';

    /**
     * @var string
     */
    const FLOOR = 'floor';

    /**
     * @var string
     */
    const LOCATION = 'location';

    /**
     * @var string
     */
    const TAG = 'tag';

    /**
     * @var string
     */
    const CATEGORY = 'category';

    /**
     * @param string $resourceType
     * @param $model
     *
     * @return JsonResource
     *
     * @throws InvalidArgumentException
     */
    public function make(string $resourceType, $model): ?JsonResource
    {
        switch ($resourceType) {
            case self::POI :
                return new PoiResource($model);
            case self::BEACON :
                return new BeaconResource($model);
            case self::FIXTURE :
                return new FixtureResource($model);
            case self::BUILDING :
                return new BuildingResource($model);
            case self::FLOOR :
                return new FloorResource($model);
            case self::LOCATION :
                return new LocationResource($model);
            case self::TAG :
                return new TagResource($model);
            case self::CATEGORY :
                return new CategoryResource($model);
            default :
                throw new InvalidArgumentException(
                    "[{$resourceType}] is not a valid resource type"
                );
        }
    }
}
