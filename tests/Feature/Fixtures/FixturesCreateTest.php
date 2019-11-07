<?php

namespace Tests\Feature\Fixtures;

use App\Models\Category;
use App\Models\Fixture;
use App\Models\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FixturesCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_fixtures()
    {
        $this->postJson(route('fixtures.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_fixtures()
    {
        $this->signIn();

        $this->postJson(route('fixtures.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_fixtures()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Fixture::all());
    }

    /** @test */
    public function a_fixture_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_fixture_requires_image_width_to_be_an_integer()
    {
        $this->create(['image_width' => 'not-a-valid-width'])->assertJsonValidationErrors('image_width');
    }

    /** @test */
    public function a_fixture_requires_image_height_to_be_an_integer()
    {
        $this->create(['image_height' => 'not-a-valid-width'])->assertJsonValidationErrors('image_height');
    }

    /** @test */
    public function category_needs_to_be_a_valid_category_object()
    {
        $this->create(['category' => ['id' => 2]])->assertJsonValidationErrors(['category.id']);
        $this->create(['category' => ['not-a-valid-category-object']])->assertJsonValidationErrors(['category']);
    }

    /** @test */
    public function tags_needs_to_be_an_array_of_valid_tag_objects()
    {
        $this->create(['tags' => 'not-a-valid-tags-array'])->assertJsonValidationErrors(['tags']);
        $this->create(['tags' => ['not-a-valid-tag-object']])->assertJsonValidationErrors(['tags.0.id']);
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['fixture:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('fixtures.store'), $this->validFields($attributes));
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
            'description' => $this->faker->paragraph,
            'image' => null,
            'image_width' => rand(0, 10),
            'image_height' => rand(0, 10),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
