<?php

namespace Tests\Feature\Fixtures;

use App\Models\Fixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FixturesDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_fixtures()
    {
        $this->postJson(route('fixtures.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('fixtures.destroy', ['fixture' => factory(Fixture::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_fixtures()
    {
        $this->signIn();
        $fixture = factory(Fixture::class)->create();
        $this->deleteJson(route('fixtures.destroy', ['fixture' => $fixture]))->assertStatus(403);

        $this->postJson(route('fixtures.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_specific_fixture()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['fixtures.delete'])
        );

        $fixture = factory(Fixture::class)->create();
        $this->deleteJson(route('fixtures.destroy', ['fixture' => $fixture]))->assertStatus(200);
        $this->assertSoftDeleted('fixtures', ['id' => $fixture->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_fixtures_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['fixtures.delete'])
        );

        $fixtures = factory(Fixture::class, 5)->create();
        $this->assertCount(5, Fixture::all());
        $this->postJson(route('fixtures.bulk-destroy'), ['items' => $fixtures])->assertStatus(200);
        $this->assertCount(0, Fixture::all());
    }
}
