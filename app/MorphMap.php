<?php

namespace App;

use App\Models\Beacon;
use App\Models\Building;
use App\Models\Category;
use App\Models\Component;
use App\Models\Container;
use App\Models\Fixture;
use App\Models\Floor;
use App\Models\Location;
use App\Models\Place;
use App\Models\Poi;
use App\Models\Skin;
use App\Models\Structure;
use App\Models\Tag;
use App\Models\User;
use App\Pivots\BeaconContainer;

class MorphMap
{
    const MAP = [
        'beacon' => Beacon::class,
        'beacon_container' => BeaconContainer::class,
        'building' => Building::class,
        'category' => Category::class,
        'component' => Component::class,
        'container' => Container::class,
        'fixture' => Fixture::class,
        'floor' => Floor::class,
        'location' => Location::class,
        'place' => Place::class,
        'poi' => Poi::class,
        'skin' => Skin::class,
        'structure' => Structure::class,
        'tag' => Tag::class,
        'user' => User::class,
    ];
}
