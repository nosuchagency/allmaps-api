<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Permission::firstOrCreate(['name' => 'activities.read', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'imports.read', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'configurations.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'configurations.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'configurations.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'configurations.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'tokens.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tokens.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tokens.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tokens.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'tokens.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tokens.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tokens.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tokens.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'users.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'users.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'users.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'users.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'roles.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'roles.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'roles.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'roles.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'places.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'places.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'places.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'places.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'buildings.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'buildings.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'buildings.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'buildings.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'floors.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'floors.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'floors.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'floors.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'beacons.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'beacons.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'beacons.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'beacons.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'beacon-providers.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'beacon-providers.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'beacon-providers.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'beacon-providers.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'pois.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'pois.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'pois.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'pois.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'fixtures.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'fixtures.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'fixtures.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'fixtures.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'hits.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'hits.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'hits.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'searchables.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'searchables.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'searchables.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'searchables.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'settings.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'settings.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'settings.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'settings.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'plugins.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'plugins.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'plugins.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'plugins.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'skins.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'skins.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'skins.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'skins.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'components.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'components.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'components.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'components.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'categories.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'categories.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'categories.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'categories.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'tags.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tags.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tags.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'tags.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'containers.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'containers.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'containers.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'containers.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'contents.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'contents.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'contents.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'contents.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'folders.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'folders.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'folders.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'folders.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'templates.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'templates.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'templates.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'templates.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'layouts.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'layouts.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'layouts.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'layouts.delete', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'menus.create', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'menus.read', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'menus.update', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'menus.delete', 'guard_name' => 'api']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $adminRole->syncPermissions([
            'activities.read',

            'imports.read',

            'configurations.create',
            'configurations.read',
            'configurations.update',
            'configurations.delete',

            'tokens.create',
            'tokens.read',
            'tokens.update',
            'tokens.delete',

            'users.create',
            'users.read',
            'users.update',
            'users.delete',

            'roles.create',
            'roles.read',
            'roles.update',
            'roles.delete',

            'places.create',
            'places.read',
            'places.update',
            'places.delete',

            'buildings.create',
            'buildings.read',
            'buildings.update',
            'buildings.delete',

            'floors.create',
            'floors.read',
            'floors.update',
            'floors.delete',

            'beacons.create',
            'beacons.read',
            'beacons.update',
            'beacons.delete',

            'beacon-providers.create',
            'beacon-providers.read',
            'beacon-providers.update',
            'beacon-providers.delete',

            'pois.create',
            'pois.read',
            'pois.update',
            'pois.delete',

            'fixtures.create',
            'fixtures.read',
            'fixtures.update',
            'fixtures.delete',

            'hits.create',
            'hits.read',
            'hits.delete',

            'searchables.create',
            'searchables.read',
            'searchables.update',
            'searchables.delete',

            'settings.create',
            'settings.read',
            'settings.update',
            'settings.delete',

            'plugins.create',
            'plugins.read',
            'plugins.update',
            'plugins.delete',

            'skins.create',
            'skins.read',
            'skins.update',
            'skins.delete',

            'components.create',
            'components.read',
            'components.update',
            'components.delete',

            'categories.create',
            'categories.read',
            'categories.update',
            'categories.delete',

            'tags.create',
            'tags.read',
            'tags.update',
            'tags.delete',

            'containers.create',
            'containers.read',
            'containers.update',
            'containers.delete',

            'contents.create',
            'contents.read',
            'contents.update',
            'contents.delete',

            'folders.create',
            'folders.read',
            'folders.update',
            'folders.delete',

            'templates.create',
            'templates.read',
            'templates.update',
            'templates.delete',

            'layouts.create',
            'layouts.read',
            'layouts.update',
            'layouts.delete',

            'menus.create',
            'menus.read',
            'menus.update',
            'menus.delete'
        ]);

        $userRole = Role::firstOrCreate(['name' => 'user']);
    }
}
