<?php

namespace Tests\Feature\Beacons;

use App\Models\Beacon;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BeaconsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_beacons()
    {
        $beacon = factory(Beacon::class)->create();

        $this->putJson(route('beacons.update', ['beacon' => $beacon]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_update_permission_cannot_update_beacons()
    {
        $this->signIn();

        $beacon = factory(Beacon::class)->create();

        $this->putJson(route('beacons.update', ['beacon' => $beacon]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_beacons()
    {
        $beacon = factory(Beacon::class)->create();

        $attributes = ['id' => $beacon->id, 'name' => $this->faker->name];

        $this->update($beacon, $attributes)->assertOk();

        $this->assertDatabaseHas('beacons', $attributes);
    }

    /**
     * @param $beacon
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($beacon, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['beacon:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('beacons.update', ['beacon' => $beacon]), $this->validFields($attributes));
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
            'identifier' => $this->faker->uuid,
            'description' => $this->faker->paragraph,
            'proximity_uuid' => $this->faker->uuid,
            'major' => $this->faker->numberBetween(0, 65535),
            'minor' => $this->faker->numberBetween(0, 65535),
            'namespace' => $this->faker->uuid,
            'instance_id' => $this->faker->uuid,
            'url' => $this->faker->url,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
