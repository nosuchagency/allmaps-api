<?php

namespace Tests\Feature\Skins;

use App\Models\Skin;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkinsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_skins()
    {
        $skin = factory(Skin::class)->create();

        $this->putJson(route('skins.update', ['skin' => $skin]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_skin()
    {
        $this->signIn();

        $skin = factory(Skin::class)->create();

        $this->putJson(route('skins.update', ['skin' => $skin]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_skins()
    {
        $skin = factory(Skin::class)->create();

        $attributes = ['id' => $skin->id, 'name' => $this->faker->name];

        $this->update($skin, $attributes)->assertOk();

        $this->assertDatabaseHas('skins', $attributes);
    }

    /**
     * @param $skin
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($skin, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['skins.update'])
        );

        return $this->putJson(route('skins.update', ['skin' => $skin]), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'name' => $this->faker->name
        ], $overrides);
    }
}
