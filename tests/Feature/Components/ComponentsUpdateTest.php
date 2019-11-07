<?php

namespace Tests\Feature\Components;

use App\ComponentType;
use App\Models\Category;
use App\Models\Component;
use App\Models\Tag;
use App\Shape;
use App\StrokeType;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComponentsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_components()
    {
        $component = factory(Component::class)->create();

        $this->putJson(route('components.update', ['component' => $component]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_update_permission_cannot_update_components()
    {
        $this->signIn();

        $component = factory(Component::class)->create();

        $this->putJson(route('components.update', ['component' => $component]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_components()
    {
        $component = factory(Component::class)->create();

        $attributes = ['id' => $component->id, 'name' => $this->faker->name];

        $this->update($component, $attributes)->assertOk();

        $this->assertDatabaseHas('components', $attributes);
    }

    /**
     * @param $component
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($component, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['component:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('components.update', ['component' => $component]), $this->validFields($attributes));
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
            'type' => $this->faker->randomElement(ComponentType::TYPES),
            'shape' => $this->faker->randomElement(Shape::SHAPES),
            'description' => $this->faker->paragraph,
            'stroke' => $this->faker->boolean,
            'stroke_type' => $this->faker->randomElement(StrokeType::TYPES),
            'stroke_color' => $this->faker->hexColor,
            'stroke_width' => $this->faker->numberBetween(1, 10),
            'stroke_opacity' => rand(0, 10) / 10,
            'fill' => $this->faker->boolean,
            'fill_color' => $this->faker->hexColor,
            'fill_opacity' => rand(0, 10) / 10,
            'image' => null,
            'image_width' => $this->faker->numberBetween(0, 10),
            'image_height' => $this->faker->numberBetween(0, 10),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
