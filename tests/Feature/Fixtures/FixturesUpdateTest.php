<?php

namespace Tests\Feature\Fixtures;

use App\Models\Category;
use App\Models\Fixture;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FixturesUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_fixtures()
    {
        $fixture = factory(Fixture::class)->create();

        $this->putJson(route('fixtures.update', ['fixture' => $fixture]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_fixtures()
    {
        $this->signIn();

        $fixture = factory(Fixture::class)->create();

        $this->putJson(route('fixtures.update', ['fixture' => $fixture]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_fixtures()
    {
        $fixture = factory(Fixture::class)->create();

        $attributes = ['id' => $fixture->id, 'name' => $this->faker->title];

        $this->update($fixture, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('fixtures', $attributes);
    }

    /**
     * @param $fixture
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($fixture, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['fixtures.update'])
        );

        return $this->putJson(route('fixtures.update', ['fixture' => $fixture]), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'image' => null,
            'width' => rand(0, 10),
            'height' => rand(0, 10),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
