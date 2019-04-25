<?php

namespace Tests\Feature\Buildings;

use App\Models\Building;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BuildingsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_buildings()
    {
        $building = factory(Building::class)->create();

        $this->putJson(route('buildings.update', ['building' => $building]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_buildings()
    {
        $this->signIn();

        $building = factory(Building::class)->create();

        $this->putJson(route('buildings.update', ['building' => $building]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_buildings()
    {
        $building = factory(Building::class)->create();

        $attributes = ['id' => $building->id, 'name' => $this->faker->title];

        $this->update($building, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('buildings', $attributes);
    }

    /**
     * @param $building
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($building, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['buildings.update'])
        );

        return $this->putJson(route('buildings.update', ['building' => $building]), $this->validFields($attributes));
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
            'image' => '',
        ], $overrides);
    }
}
