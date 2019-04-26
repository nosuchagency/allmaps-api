<?php

namespace Tests\Feature\Components;

use App\Models\Category;
use App\Models\Component;
use App\Models\Tag;
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
    public function an_authenticated_user_without_create_permission_cannot_update_components()
    {
        $this->signIn();

        $component = factory(Component::class)->create();

        $this->putJson(route('components.update', ['component' => $component]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_components()
    {
        $component = factory(Component::class)->create();

        $attributes = ['id' => $component->id, 'name' => $this->faker->title];

        $this->update($component, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('components', $attributes);
    }

    /**
     * @param $component
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($component, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['components.update'])
        );

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
