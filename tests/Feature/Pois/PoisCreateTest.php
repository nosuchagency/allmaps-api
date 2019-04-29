<?php

namespace Tests\Feature\Pois;

use App\Models\Category;
use App\Models\Poi;
use App\Models\Tag;
use App\PoiTypes;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoisCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_pois()
    {
        $this->postJson(route('pois.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_pois()
    {
        $this->signIn();

        $this->postJson(route('pois.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_pois()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Poi::all());
    }

    /** @test */
    public function a_poi_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_poi_requires_a_type_of_image_or_area()
    {
        $this->create(['type' => null])->assertJsonValidationErrors('type');
        $this->create(['type' => 'not-a-valid-type'])->assertJsonValidationErrors('type');
    }

    /** @test */
    public function a_poi_requires_color_to_be_a_valid_hex_color()
    {
        $this->create(['color' => 'not-a-valid-hex-color'])->assertJsonValidationErrors('color');
    }

    /** @test */
    public function category_needs_to_be_a_valid_category_object()
    {
        $this->create(['category' => ['id' => 2]])->assertJsonValidationErrors(['category.id']);
        $this->create(['category' => ['not-a-valid-category-object']])->assertJsonValidationErrors(['category']);
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
            $this->createRoleWithPermissions(['pois.create'])
        );

        return $this->postJson(route('pois.store'), $this->validFields($attributes));
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
            'type' => $this->faker->randomElement(PoiTypes::TYPES),
            'color' => $this->faker->hexColor,
            'image' => null,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
