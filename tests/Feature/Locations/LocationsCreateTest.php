<?php

namespace Tests\Feature\Locations;

use App\Models\Beacon;
use App\Models\Category;
use App\Models\Floor;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_locations()
    {
        $this->postJson(route('locations.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_locations()
    {
        $this->signIn();

        $this->postJson(route('locations.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_locations()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Location::all());
    }

    /** @test */
    public function a_location_requires_a_floor()
    {
        $this->create(['floor' => null])->assertJsonValidationErrors(['floor', 'floor.id']);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.create'])
        );

        return $this->postJson(route('locations.store'), $this->validFields($attributes));
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
            'floor' => factory(Floor::class)->create(),
            'beacon' => factory(Beacon::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
