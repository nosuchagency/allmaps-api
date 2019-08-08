<?php

namespace Tests\Feature\Folders;

use App\Models\Category;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FoldersUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_folders()
    {
        $folder = factory(Folder::class)->create();

        $this->putJson(route('folders.update', ['folder' => $folder]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_folders()
    {
        $this->signIn();

        $folder = factory(Folder::class)->create();

        $this->putJson(route('folders.update', ['folder' => $folder]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_folders()
    {
        $folder = factory(Folder::class)->create();

        $attributes = ['id' => $folder->id, 'name' => $this->faker->name];

        $this->update($folder, $attributes)->assertOk();

        $this->assertDatabaseHas('folders', $attributes);
    }

    /**
     * @param $folder
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($folder, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['folders.update'])
        );

        return $this->putJson(route('folders.update', ['folder' => $folder]), $this->validFields($attributes));
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
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
