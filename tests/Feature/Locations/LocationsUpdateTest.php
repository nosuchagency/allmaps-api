<?php

namespace Tests\Feature\Locations;

use App\Models\Location;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_locations()
    {
        $location = factory(Location::class)->create();

        $this->putJson(route('locations.update', ['location' => $location]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_locations()
    {
        $this->signIn();

        $location = factory(Location::class)->create();

        $this->putJson(route('locations.update', ['location' => $location]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_locations()
    {
        $location = factory(Location::class)->create();

        $attributes = ['id' => $location->id, 'name' => $this->faker->title];

        $this->update($location, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('locations', $attributes);
    }

    /**
     * @param $location
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($location, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.update'])
        );

        return $this->putJson(route('locations.update', ['location' => $location]), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->title
        ], $overrides);
    }
}