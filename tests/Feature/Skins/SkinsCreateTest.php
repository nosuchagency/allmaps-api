<?php

namespace Tests\Feature\Skins;

use App\Models\Skin;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SkinsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_skins()
    {
        $this->postJson(route('skins.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_skins()
    {
        $this->signIn();

        $this->postJson(route('skins.store'))->assertStatus(403);
    }

//    /** @test */
//    public function an_authenticated_user_with_create_permission_can_create_skins()
//    {
//        $this->create()->assertStatus(201);
//        $this->assertCount(1, Skin::all());
//    }

    /** @test */
    public function name_is_required()
    {
        $this->create(['name' => null])->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function name_needs_to_be_unique()
    {
        $skin = factory(Skin::class)->create();

        $this->create(['name' => $skin->name])->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function a_skin_requires_a_valid_zip_file()
    {
        $this->create(['file' => null])->assertJsonValidationErrors(['file']);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['skins.create'])
        );

        return $this->postJson(route('skins.store'), $this->validFields($attributes));
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
