<?php

namespace Tests\Feature\Contents;

use App\ContentType;
use App\Models\Category;
use App\Models\Content\Content;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContentsUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_contents()
    {
        $content = factory(Content::class)->create();

        $this->putJson(route('contents.update', ['content' => $content]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_update_permission_cannot_update_contents()
    {
        $this->signIn();

        $content = factory(Content::class)->create();

        $this->putJson(route('contents.update', ['content' => $content]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_contents()
    {
        $content = factory(Content::class)->create();

        $attributes = ['id' => $content->id, 'name' => $this->faker->name];

        $this->update($content, $attributes)->assertOk();

        $this->assertDatabaseHas('contents', $attributes);
    }

    /**
     * @param $content
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($content, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['content:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('contents.update', ['content' => $content]), $this->validFields($attributes));
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
            'text' => $this->faker->paragraph,
            'image' => null,
            'url' => $this->faker->url,
            'yt_url' => $this->faker->url,
            'type' => $this->faker->randomElement(ContentType::TYPES),
            'folder' => factory(Folder::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
