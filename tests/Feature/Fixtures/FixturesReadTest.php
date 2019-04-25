<?php

namespace Tests\Feature\Fixtures;

use App\Models\Fixture;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FixturesReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_fixtures()
    {
        $fixture = factory(Fixture::class)->create();

        $this->getJson(route('fixtures.index'))->assertStatus(401);
        $this->getJson(route('fixtures.show', ['fixture' => $fixture]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_fixtures()
    {
        $this->signIn();

        $this->getJson(route('fixtures.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_fixtures()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['fixtures.read'])
        );

        $this->getJson(route('fixtures.index'))->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_fixture()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['fixtures.read'])
        );

        $fixture = factory(Fixture::class)->create();

        $this->getJson(route('fixtures.show', ['fixture' => $fixture]))->assertStatus(200);
    }
}