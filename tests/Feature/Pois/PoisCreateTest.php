<?php

namespace Tests\Feature\Pois;

use App\Models\Category;
use App\Models\Poi;
use App\Models\Tag;
use App\PoiTypes;
use App\StrokeType;
use Illuminate\Foundation\Testing\TestResponse;
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
    public function a_poi_requires_stroke_to_be_a_valid_boolean()
    {
        $this->create(['stroke' => 'not-a-valid-boolean'])->assertJsonValidationErrors('stroke');
    }

    /** @test */
    public function a_poi_requires_stroke_color_to_be_a_valid_hex_color()
    {
        $this->create(['stroke_color' => 'not-a-valid-hex-color'])->assertJsonValidationErrors('stroke_color');
    }

    /** @test */
    public function a_poi_requires_fill_to_be_a_valid_boolean()
    {
        $this->create(['fill' => 'not-a-valid-boolean'])->assertJsonValidationErrors('fill');
    }

    /** @test */
    public function a_poi_requires_fill_color_to_be_a_valid_hex_color()
    {
        $this->create(['fill_color' => 'not-a-valid-hex-color'])->assertJsonValidationErrors('fill_color');
    }

    /** @test */
    public function a_poi_requires_stroke_opacity_to_be_between_0_and_1()
    {
        $this->create(['stroke_opacity' => -0.01])->assertJsonValidationErrors('stroke_opacity');
        $this->create(['stroke_opacity' => 'not-a-valid-opacity'])->assertJsonValidationErrors('stroke_opacity');
        $this->create(['stroke_opacity' => 1.01])->assertJsonValidationErrors('stroke_opacity');
    }

    /** @test */
    public function a_poi_requires_fill_opacity_to_be_between_0_and_1()
    {
        $this->create(['fill_opacity' => -0.01])->assertJsonValidationErrors('fill_opacity');
        $this->create(['fill_opacity' => 'not-a-valid-opacity'])->assertJsonValidationErrors('fill_opacity');
        $this->create(['fill_opacity' => 1.01])->assertJsonValidationErrors('fill_opacity');
    }

    /** @test */
    public function a_poi_requires_stroke_width_to_be_a_valid_integer()
    {
        $this->create(['stroke_width' => -1])->assertJsonValidationErrors('stroke_width');
        $this->create(['stroke_width' => 'not-a-valid-stroke_width'])->assertJsonValidationErrors('stroke_width');
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
     * @return TestResponse
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
            'stroke' => $this->faker->boolean,
            'stroke_type' => $this->faker->randomElement(StrokeType::TYPES),
            'stroke_color' => $this->faker->hexColor,
            'stroke_width' => $this->faker->numberBetween(1, 10),
            'stroke_opacity' => rand(0, 10) / 10,
            'fill' => $this->faker->boolean,
            'fill_color' => $this->faker->hexColor,
            'fill_opacity' => rand(0, 10) / 10,
            'image' => null,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
