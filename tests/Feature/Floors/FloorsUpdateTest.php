<?php

namespace Tests\Feature\Floors;

use App\Models\Floor;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FloorsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_floors()
    {
        $floor = factory(Floor::class)->create();

        $this->putJson(route('floors.update', ['floor' => $floor]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_floors()
    {
        $this->signIn();

        $floor = factory(Floor::class)->create();

        $this->putJson(route('floors.update', ['floor' => $floor]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_floors()
    {
        $floor = factory(Floor::class)->create();

        $attributes = ['id' => $floor->id, 'name' => $this->faker->name];

        $this->update($floor, $attributes)->assertOk();

        $this->assertDatabaseHas('floors', $attributes);
    }

    /**
     * @param $floor
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($floor, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['floor:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('floors.update', ['floor' => $floor]), $this->validFields($attributes));
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
            'level' => $this->faker->randomNumber(),
            'image' => null,
        ], $overrides);
    }
}
