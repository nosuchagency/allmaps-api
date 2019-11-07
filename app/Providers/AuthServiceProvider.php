<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Beacon;
use App\Models\BeaconProvider;
use App\Models\Building;
use App\Models\Category;
use App\Models\Component;
use App\Models\Container;
use App\Models\Content\Content;
use App\Models\Fixture;
use App\Models\Floor;
use App\Models\Folder;
use App\Models\Hit;
use App\Models\Import;
use App\Models\Layout;
use App\Models\Location;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Permission;
use App\Models\Place;
use App\Models\Poi;
use App\Models\Role;
use App\Models\Rule;
use App\Models\Searchable;
use App\Models\Skin;
use App\Models\Structure;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Token;
use App\Models\User;
use App\Pivots\BeaconContainer;
use App\Policies\ActivityPolicy;
use App\Policies\BeaconContainerPolicy;
use App\Policies\BeaconPolicy;
use App\Policies\BeaconProviderPolicy;
use App\Policies\BuildingPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ComponentPolicy;
use App\Policies\ContainerPolicy;
use App\Policies\ContentPolicy;
use App\Policies\FixturePolicy;
use App\Policies\FloorPolicy;
use App\Policies\FolderPolicy;
use App\Policies\HitPolicy;
use App\Policies\ImportPolicy;
use App\Policies\LayoutPolicy;
use App\Policies\LocationPolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PlacePolicy;
use App\Policies\PoiPolicy;
use App\Policies\RolePolicy;
use App\Policies\RulePolicy;
use App\Policies\SearchablePolicy;
use App\Policies\SkinPolicy;
use App\Policies\StructurePolicy;
use App\Policies\TagPolicy;
use App\Policies\TemplatePolicy;
use App\Policies\TokenPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Activity::class => ActivityPolicy::class,
        Beacon::class => BeaconPolicy::class,
        BeaconContainer::class => BeaconContainerPolicy::class,
        BeaconProvider::class => BeaconProviderPolicy::class,
        Building::class => BuildingPolicy::class,
        Category::class => CategoryPolicy::class,
        Component::class => ComponentPolicy::class,
        Container::class => ContainerPolicy::class,
        Content::class => ContentPolicy::class,
        Fixture::class => FixturePolicy::class,
        Floor::class => FloorPolicy::class,
        Folder::class => FolderPolicy::class,
        Hit::class => HitPolicy::class,
        Import::class => ImportPolicy::class,
        Layout::class => LayoutPolicy::class,
        Location::class => LocationPolicy::class,
        Menu::class => MenuPolicy::class,
        MenuItem::class => MenuItemPolicy::class,
        Permission::class => PermissionPolicy::class,
        Place::class => PlacePolicy::class,
        Poi::class => PoiPolicy::class,
        Role::class => RolePolicy::class,
        Rule::class => RulePolicy::class,
        Searchable::class => SearchablePolicy::class,
        Skin::class => SkinPolicy::class,
        Structure::class => StructurePolicy::class,
        Tag::class => TagPolicy::class,
        Template::class => TemplatePolicy::class,
        Token::class => TokenPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
