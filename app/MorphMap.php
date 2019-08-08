<?php

namespace App;

use App\Models\Beacon;
use App\Models\Building;
use App\Models\Category;
use App\Models\Component;
use App\Models\Container;
use App\Models\Fixture;
use App\Models\Floor;
use App\Models\Folder;
use App\Models\Import;
use App\Models\Layout;
use App\Models\Location;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Place;
use App\Models\Poi;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Skin;
use App\Models\Structure;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Token;
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
        'folder' => Folder::class,
        'import' => Import::class,
        'layout' => Layout::class,
        'location' => Location::class,
        'menu' => Menu::class,
        'menu_item' => MenuItem::class,
        'place' => Place::class,
        'poi' => Poi::class,
        'role' => Role::class,
        'rule' => Rule::class,
        'skin' => Skin::class,
        'structure' => Structure::class,
        'tag' => Tag::class,
        'template' => Template::class,
        'token' => Token::class,
        'user' => User::class,
    ];
}
