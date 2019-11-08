<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        activity()->disableLogging();

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $userRole = Role::firstOrCreate(['name' => 'user']);

        activity()->enableLogging();

        $adminRole->permissions()->sync([
            Permission::firstOrCreate(['name' => 'activity:create'])->id,
            Permission::firstOrCreate(['name' => 'activity:read'])->id,
            Permission::firstOrCreate(['name' => 'activity:update'])->id,
            Permission::firstOrCreate(['name' => 'activity:delete'])->id,

            Permission::firstOrCreate(['name' => 'beacon:create'])->id,
            Permission::firstOrCreate(['name' => 'beacon:read'])->id,
            Permission::firstOrCreate(['name' => 'beacon:update'])->id,
            Permission::firstOrCreate(['name' => 'beacon:delete'])->id,

            Permission::firstOrCreate(['name' => 'beacon-provider:create'])->id,
            Permission::firstOrCreate(['name' => 'beacon-provider:read'])->id,
            Permission::firstOrCreate(['name' => 'beacon-provider:update'])->id,
            Permission::firstOrCreate(['name' => 'beacon-provider:delete'])->id,

            Permission::firstOrCreate(['name' => 'building:create'])->id,
            Permission::firstOrCreate(['name' => 'building:read'])->id,
            Permission::firstOrCreate(['name' => 'building:update'])->id,
            Permission::firstOrCreate(['name' => 'building:delete'])->id,

            Permission::firstOrCreate(['name' => 'category:create'])->id,
            Permission::firstOrCreate(['name' => 'category:read'])->id,
            Permission::firstOrCreate(['name' => 'category:update'])->id,
            Permission::firstOrCreate(['name' => 'category:delete'])->id,

            Permission::firstOrCreate(['name' => 'component:create'])->id,
            Permission::firstOrCreate(['name' => 'component:read'])->id,
            Permission::firstOrCreate(['name' => 'component:update'])->id,
            Permission::firstOrCreate(['name' => 'component:delete'])->id,

            Permission::firstOrCreate(['name' => 'container:create'])->id,
            Permission::firstOrCreate(['name' => 'container:read'])->id,
            Permission::firstOrCreate(['name' => 'container:update'])->id,
            Permission::firstOrCreate(['name' => 'container:delete'])->id,

            Permission::firstOrCreate(['name' => 'content:create'])->id,
            Permission::firstOrCreate(['name' => 'content:read'])->id,
            Permission::firstOrCreate(['name' => 'content:update'])->id,
            Permission::firstOrCreate(['name' => 'content:delete'])->id,

            Permission::firstOrCreate(['name' => 'fixture:create'])->id,
            Permission::firstOrCreate(['name' => 'fixture:read'])->id,
            Permission::firstOrCreate(['name' => 'fixture:update'])->id,
            Permission::firstOrCreate(['name' => 'fixture:delete'])->id,

            Permission::firstOrCreate(['name' => 'floor:create'])->id,
            Permission::firstOrCreate(['name' => 'floor:read'])->id,
            Permission::firstOrCreate(['name' => 'floor:update'])->id,
            Permission::firstOrCreate(['name' => 'floor:delete'])->id,

            Permission::firstOrCreate(['name' => 'folder:create'])->id,
            Permission::firstOrCreate(['name' => 'folder:read'])->id,
            Permission::firstOrCreate(['name' => 'folder:update'])->id,
            Permission::firstOrCreate(['name' => 'folder:delete'])->id,

            Permission::firstOrCreate(['name' => 'hit:create'])->id,
            Permission::firstOrCreate(['name' => 'hit:read'])->id,
            Permission::firstOrCreate(['name' => 'hit:update'])->id,
            Permission::firstOrCreate(['name' => 'hit:delete'])->id,

            Permission::firstOrCreate(['name' => 'import:create'])->id,
            Permission::firstOrCreate(['name' => 'import:read'])->id,
            Permission::firstOrCreate(['name' => 'import:update'])->id,
            Permission::firstOrCreate(['name' => 'import:delete'])->id,

            Permission::firstOrCreate(['name' => 'layout:create'])->id,
            Permission::firstOrCreate(['name' => 'layout:read'])->id,
            Permission::firstOrCreate(['name' => 'layout:update'])->id,
            Permission::firstOrCreate(['name' => 'layout:delete'])->id,

            Permission::firstOrCreate(['name' => 'location:create'])->id,
            Permission::firstOrCreate(['name' => 'location:read'])->id,
            Permission::firstOrCreate(['name' => 'location:update'])->id,
            Permission::firstOrCreate(['name' => 'location:delete'])->id,

            Permission::firstOrCreate(['name' => 'menu:create'])->id,
            Permission::firstOrCreate(['name' => 'menu:read'])->id,
            Permission::firstOrCreate(['name' => 'menu:update'])->id,
            Permission::firstOrCreate(['name' => 'menu:delete'])->id,

            Permission::firstOrCreate(['name' => 'menu-item:create'])->id,
            Permission::firstOrCreate(['name' => 'menu-item:read'])->id,
            Permission::firstOrCreate(['name' => 'menu-item:update'])->id,
            Permission::firstOrCreate(['name' => 'menu-item:delete'])->id,

            Permission::firstOrCreate(['name' => 'permission:create'])->id,
            Permission::firstOrCreate(['name' => 'permission:read'])->id,
            Permission::firstOrCreate(['name' => 'permission:update'])->id,
            Permission::firstOrCreate(['name' => 'permission:delete'])->id,

            Permission::firstOrCreate(['name' => 'place:create'])->id,
            Permission::firstOrCreate(['name' => 'place:read'])->id,
            Permission::firstOrCreate(['name' => 'place:update'])->id,
            Permission::firstOrCreate(['name' => 'place:delete'])->id,

            Permission::firstOrCreate(['name' => 'plugin:create'])->id,
            Permission::firstOrCreate(['name' => 'plugin:read'])->id,
            Permission::firstOrCreate(['name' => 'plugin:update'])->id,
            Permission::firstOrCreate(['name' => 'plugin:delete'])->id,

            Permission::firstOrCreate(['name' => 'poi:create'])->id,
            Permission::firstOrCreate(['name' => 'poi:read'])->id,
            Permission::firstOrCreate(['name' => 'poi:update'])->id,
            Permission::firstOrCreate(['name' => 'poi:delete'])->id,

            Permission::firstOrCreate(['name' => 'role:create'])->id,
            Permission::firstOrCreate(['name' => 'role:read'])->id,
            Permission::firstOrCreate(['name' => 'role:update'])->id,
            Permission::firstOrCreate(['name' => 'role:delete'])->id,

            Permission::firstOrCreate(['name' => 'rule:create'])->id,
            Permission::firstOrCreate(['name' => 'rule:read'])->id,
            Permission::firstOrCreate(['name' => 'rule:update'])->id,
            Permission::firstOrCreate(['name' => 'rule:delete'])->id,

            Permission::firstOrCreate(['name' => 'searchable:create'])->id,
            Permission::firstOrCreate(['name' => 'searchable:read'])->id,
            Permission::firstOrCreate(['name' => 'searchable:update'])->id,
            Permission::firstOrCreate(['name' => 'searchable:delete'])->id,

            Permission::firstOrCreate(['name' => 'skin:create'])->id,
            Permission::firstOrCreate(['name' => 'skin:read'])->id,
            Permission::firstOrCreate(['name' => 'skin:update'])->id,
            Permission::firstOrCreate(['name' => 'skin:delete'])->id,

            Permission::firstOrCreate(['name' => 'structure:create'])->id,
            Permission::firstOrCreate(['name' => 'structure:read'])->id,
            Permission::firstOrCreate(['name' => 'structure:update'])->id,
            Permission::firstOrCreate(['name' => 'structure:delete'])->id,

            Permission::firstOrCreate(['name' => 'tag:create'])->id,
            Permission::firstOrCreate(['name' => 'tag:read'])->id,
            Permission::firstOrCreate(['name' => 'tag:update'])->id,
            Permission::firstOrCreate(['name' => 'tag:delete'])->id,

            Permission::firstOrCreate(['name' => 'template:create'])->id,
            Permission::firstOrCreate(['name' => 'template:read'])->id,
            Permission::firstOrCreate(['name' => 'template:update'])->id,
            Permission::firstOrCreate(['name' => 'template:delete'])->id,

            Permission::firstOrCreate(['name' => 'token:create'])->id,
            Permission::firstOrCreate(['name' => 'token:read'])->id,
            Permission::firstOrCreate(['name' => 'token:update'])->id,
            Permission::firstOrCreate(['name' => 'token:delete'])->id,

            Permission::firstOrCreate(['name' => 'user:create'])->id,
            Permission::firstOrCreate(['name' => 'user:read'])->id,
            Permission::firstOrCreate(['name' => 'user:update'])->id,
            Permission::firstOrCreate(['name' => 'user:delete'])->id,
        ]);
    }
}
