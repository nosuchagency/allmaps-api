<?php

namespace Tests\Feature\Tags;

use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_tags()
    {
        $tag = factory(Tag::class)->create();

        $this->putJson(route('tags.update', ['tag' => $tag]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_tags()
    {
        $this->signIn();

        $tag = factory(Tag::class)->create();

        $this->putJson(route('tags.update', ['tag' => $tag]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_tags()
    {
        $tag = factory(Tag::class)->create();

        $attributes = ['id' => $tag->id, 'name' => $this->faker->title];

        $this->update($tag, $attributes)->assertStatus(200);

        $this->assertDatabaseHas('tags', $attributes);
    }

    /**
     * @param $tag
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function update($tag, $attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['tags.update'])
        );

        return $this->putJson(route('tags.update', ['tag' => $tag]), $this->validFields($attributes));
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
            'description' => $this->faker->paragraph
        ], $overrides);
    }
}
