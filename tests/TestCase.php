<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
    }

    public function seedRolesAndPermissions()
    {
        $this->artisan('db:seed', [
            '--class' => 'RolesAndPermissionsSeederWeb'
        ]);
    }

    public function seedRolesAndPermissionsToken()
    {
        $this->artisan('db:seed', [
            '--class' => 'RolesAndPermissionsSeederToken'
        ]);
    }

    public function seedEmailTemplates()
    {
        $this->artisan('db:seed', [
            '--class' => 'EmailTemplatesSeeder'
        ]);
    }

    public function restoreEmailTemplates()
    {
        $layoutTemplate = File::get(resource_path('views/emails/templates/layout.html'));

        File::put(resource_path('views/emails/layout.html'), $layoutTemplate);
    }

    public function getUser()
    {
        $dispatcher = User::getEventDispatcher();

        User::unsetEventDispatcher();

        $user = factory('App\User')->create();

        User::setEventDispatcher($dispatcher);

        return $user;
    }
}
