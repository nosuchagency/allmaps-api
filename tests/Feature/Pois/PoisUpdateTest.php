<?php

namespace Tests\Feature\Pois;

use App\Models\Category;
use App\Models\Poi;
use App\Models\Tag;
use App\PoiTypes;
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

        $attributes = ['id' => $poi->id, 'name' => $this->faker->name];

        $this->update($poi, $attributes)->assertOk();

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
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(PoiTypes::TYPES),
            'color' => $this->faker->hexColor,
            'image' => null,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
