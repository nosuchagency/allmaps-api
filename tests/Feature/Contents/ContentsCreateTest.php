<?php

namespace Tests\Feature\Contents;

use App\Models\Category;
use App\Models\Content\Content;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContentsCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_contents()
    {
        $this->postJson(route('contents.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_contents()
    {
        $this->signIn();

        $this->postJson(route('contents.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_containers()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Content::all());
    }

    /** @test */
    public function a_content_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_content_requires_a_valid_type()
    {
        $this->create(['type' => null])->assertJsonValidationErrors('type');
        $this->create(['type' => 'not-a-valid-type'])->assertJsonValidationErrors('type');
    }

    /** @test */
    public function a_content_requires_a_folder()
    {
        $this->create(['folder' => null])->assertJsonValidationErrors('folder');
    }

    /** @test */
    public function category_needs_to_be_a_valid_category_object()
    {
        $this->create(['category' => ['id' => 2]])->assertJsonValidationErrors(['category.id']);
        $this->create(['category' => []])->assertJsonValidationErrors(['category']);
    }

    /** @test */
    public function tags_needs_to_be_an_array_of_valid_tag_objects()
    {
        $this->create(['tags' => 'not-a-valid-tags-array'])->assertJsonValidationErrors(['tags']);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['contents.create'])
        );

        return $this->postJson(route('contents.store'), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        $folder = factory(Folder::class)->create();

        return array_merge([
            'name' => $this->faker->title,
            'type' => $this->faker->randomElement(['image', 'video', 'text', 'gallery', 'file', 'web']),
            'folder' => $folder,
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
