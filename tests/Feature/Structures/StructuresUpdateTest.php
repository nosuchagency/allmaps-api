<?php

namespace Tests\Feature\Structures;

use App\Models\Structure;
use Illuminate\Foundation\Testing\TestResponse;
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

        $attributes = ['id' => $structure->id, 'name' => $this->faker->name];

        $this->update($structure, $attributes)->assertOk();

        $this->assertDatabaseHas('structures', $attributes);
    }

    /**
     * @param $structure
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($structure, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['structure:update']);

        $this->signIn(null, $role);

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
            'name' => $this->faker->name,
            'coordinates' => [],
            'markers' => [],
            'radius' => 5
        ], $overrides);
    }
}
