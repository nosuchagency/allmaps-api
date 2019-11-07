<?php

namespace Tests\Feature\Fixtures;

use App\Models\Category;
use App\Models\Fixture;
use App\Models\Tag;
use Illuminate\Foundation\Testing\TestResponse;
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

        $attributes = ['id' => $fixture->id, 'name' => $this->faker->name];

        $this->update($fixture, $attributes)->assertOk();

        $this->assertDatabaseHas('fixtures', $attributes);
    }

    /**
     * @param $fixture
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($fixture, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['fixture:update']);

        $this->signIn(null, $role);

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
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'image' => null,
            'image_width' => rand(0, 10),
            'image_height' => rand(0, 10),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
