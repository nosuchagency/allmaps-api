<?php

namespace Tests\Feature\Structures;

use App\Models\Structure;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StructuresUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_structures()
    {
        $structure = factory(Structure::class)->create();

        $this->putJson(route('structures.update', ['structure' => $structure]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_structure()
    {
        $this->signIn();

        $structure = factory(Structure::class)->create();

        $this->putJson(route('structures.update', ['structure' => $structure]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_structures()
    {
        $structure = factory(Structure::class)->create();

        $attributes = ['id' => $structure->id, 'name' => $this->faker->title];

        $this->update($structure, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('structures', $attributes);
    }

    /**
     * @param $structure
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($structure, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['floors.update'])
        );

        return $this->putJson(route('structures.update', ['structure' => $structure]), $this->validFields($attributes));
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
            'coordinates' => [],
            'markers' => [],
            'radius' => ''
        ], $overrides);
    }
}
