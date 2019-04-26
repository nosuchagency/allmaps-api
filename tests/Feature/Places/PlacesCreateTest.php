<?php

namespace Tests\Feature\Places;

use App\Models\Category;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlacesCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_places()
    {
        $this->postJson(route('places.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_places()
    {
        $this->signIn();

        $this->postJson(route('places.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_places()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Place::all());
    }

    /** @test */
    public function a_place_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_place_requires_a_valid_latitude()
    {
        $this->create(['latitude' => 'not-a-valid-latitude'])->assertJsonValidationErrors('latitude');
    }

    /** @test */
    public function a_place_requires_a_valid_longitude()
    {
        $this->create(['longitude' => 'not-a-valid-longitude'])->assertJsonValidationErrors('longitude');
    }

    /** @test */
    public function a_place_requires_activated_to_be_a_boolean()
    {
        $this->create(['activated' => 'not-a-boolean'])->assertJsonValidationErrors('activated');
    }

    /** @test */
    public function category_needs_to_be_a_valid_category_object()
    {
        $this->create(['category' => ['id' => 2]])->assertJsonValidationErrors(['category.id']);
        $this->create(['category' => []])->assertJsonValidationErrors(['category']);
    }

    /** @test */
    public function tags_needs_to_be_an_array_of_valid_tag_objects()
    {
        $this->create(['tags' => 'not-a-valid-tags-array'])->assertJsonValidationErrors(['tags']);
        $this->create(['tags' => ['not-a-valid-tag-object']])->assertJsonValidationErrors(['tags.0.id']);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['places.create'])
        );

        return $this->postJson(route('places.store'), $this->validFields($attributes));
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
            'address' => $this->faker->address,
            'postcode' => $this->faker->postcode,
            'city' => $this->faker->city,
            'image' => null,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'activated' => $this->faker->boolean,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
