<?php

namespace Tests\Feature\Beacons;

use App\Models\Beacon;
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
    public function an_authenticated_user_without_create_permission_cannot_update_beacons()
    {
        $this->signIn();

        $beacon = factory(Beacon::class)->create();

        $this->putJson(route('beacons.update', ['beacon' => $beacon]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_beacons()
    {
        $beacon = factory(Beacon::class)->create();

        $attributes = ['id' => $beacon->id, 'name' => $this->faker->title];

        $this->update($beacon, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('beacons', $attributes);
    }

    /**
     * @param $beacon
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($beacon, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['beacons.update'])
        );

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
            'name' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'proximity_uuid' => $this->faker->uuid,
            'major' => $this->faker->numberBetween(0, 65535),
            'minor' => $this->faker->numberBetween(0, 65535),
            'eddystone_uid' => $this->faker->uuid,
            'eddystone_url' => $this->faker->url,
            'eddystone_tlm' => $this->faker->title,
            'eddystone_eid' => $this->faker->title,
            'category' => null,
            'tags' => []
        ], $overrides);
    }
}
