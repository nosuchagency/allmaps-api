<?php

namespace Tests\Feature\Components;

use App\Models\Category;
use App\Models\Component;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComponentsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_components()
    {
        $this->postJson(route('components.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_components()
    {
        $this->signIn();

        $this->postJson(route('components.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_components()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Component::all());
    }

    /** @test */
    public function a_component_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_component_requires_a_valid_type()
    {
        $this->create(['type' => null])->assertJsonValidationErrors('type');
        $this->create(['type' => 'not-a-valid-type'])->assertJsonValidationErrors('type');
    }

    /** @test */
    public function a_component_requires_a_valid_shape()
    {
        $this->create(['shape' => null])->assertJsonValidationErrors('shape');
        $this->create(['shape' => 'not-a-valid-shape'])->assertJsonValidationErrors('shape');
    }

    /** @test */
    public function a_component_requires_color_to_be_a_valid_hex_color()
    {
        $this->create(['color' => 'not-a-valid-hex-color'])->assertJsonValidationErrors('color');
    }

    /** @test */
    public function a_component_requires_opacity_to_be_between_0_and_1()
    {
        $this->create(['opacity' => -0.01])->assertJsonValidationErrors('opacity');
        $this->create(['opacity' => 'not-a-valid-opacity'])->assertJsonValidationErrors('opacity');
        $this->create(['opacity' => 1.01])->assertJsonValidationErrors('opacity');
    }

    /** @test */
    public function a_component_requires_weight_to_be_a_valid_integer()
    {
        $this->create(['weight' => -1])->assertJsonValidationErrors('weight');
        $this->create(['weight' => 'not-a-valid-weight'])->assertJsonValidationErrors('weight');
        $this->create(['weight' => 11])->assertJsonValidationErrors('weight');
    }

    /** @test */
    public function a_component_requires_curved_to_be_a_valid_boolean()
    {
        $this->create(['curved' => 'not-a-valid-boolean'])->assertJsonValidationErrors('curved');
    }

    /** @test */
    public function a_component_requires_width_to_be_a_valid_integer()
    {
        $this->create(['width' => 'not-a-valid-width'])->assertJsonValidationErrors('width');
        $this->create(['width' => -1])->assertJsonValidationErrors('width');
    }

    /** @test */
    public function a_component_requires_height_to_be_a_valid_integer()
    {
        $this->create(['height' => 'not-a-valid-height'])->assertJsonValidationErrors('height');
        $this->create(['height' => -1])->assertJsonValidationErrors('height');
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
            $this->createRoleWithPermissions(['components.create'])
        );

        return $this->postJson(route('components.store'), $this->validFields($attributes));
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
            'type' => $this->faker->randomElement(['plan', 'wall', 'room', 'decor']),
            'shape' => $this->faker->randomElement(['polyline', 'polygon', 'rectangle', 'circle', 'image']),
            'color' => $this->faker->hexColor,
            'opacity' => rand(0, 10) / 10,
            'weight' => $this->faker->numberBetween(1, 10),
            'curved' => $this->faker->boolean,
            'width' => $this->faker->numberBetween(0, 10),
            'height' => $this->faker->numberBetween(0, 10),
            'image' => null,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
