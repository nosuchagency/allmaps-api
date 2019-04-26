<?php

namespace Tests\Feature\Pois;

use App\Models\Category;
use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PoisUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_pois()
    {
        $poi = factory(Poi::class)->create();

        $this->putJson(route('pois.update', ['poi' => $poi]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_pois()
    {
        $this->signIn();

        $poi = factory(Poi::class)->create();

        $this->putJson(route('pois.update', ['poi' => $poi]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_pois()
    {
        $poi = factory(Poi::class)->create();

        $attributes = ['id' => $poi->id, 'name' => $this->faker->title];

        $this->update($poi, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('pois', $attributes);
    }

    /**
     * @param $poi
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($poi, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['pois.update'])
        );

        return $this->putJson(route('pois.update', ['poi' => $poi]), $this->validFields($attributes));
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
            'type' => $this->faker->randomElement(['area', 'image']),
            'color' => $this->faker->hexColor,
            'image' => null,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
