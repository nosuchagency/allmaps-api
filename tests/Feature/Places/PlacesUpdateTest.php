<?php

namespace Tests\Feature\Places;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlacesUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_places()
    {
        $place = factory(Place::class)->create();

        $this->putJson(route('places.update', ['place' => $place]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_places()
    {
        $this->signIn();

        $place = factory(Place::class)->create();

        $this->putJson(route('places.update', ['place' => $place]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_places()
    {
        $place = factory(Place::class)->create();

        $attributes = ['id' => $place->id, 'name' => $this->faker->name];

        $this->update($place, $attributes)->assertOk();

        $this->assertDatabaseHas('places', $attributes);
    }

    /**
     * @param $place
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($place, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.update'])
        );

        return $this->putJson(route('places.update', ['place' => $place]), $this->validFields($attributes));
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
            'address' => $this->faker->address,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'image' => null,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'activated' => $this->faker->boolean,
            'menu' => factory(Menu::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
