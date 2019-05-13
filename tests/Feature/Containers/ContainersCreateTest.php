<?php

namespace Tests\Feature\Containers;

use App\Models\Category;
use App\Models\Container;
use App\Models\Skin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainersCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_containers()
    {
        $this->postJson(route('containers.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_containers()
    {
        $this->signIn();
        $this->postJson(route('containers.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_containers()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Container::all());
    }

    /** @test */
    public function a_container_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function a_container_requires_folders_enabled_to_be_a_valid_boolean()
    {
        $this->create(['folders_enabled' => 'not-a-valid-boolean'])->assertJsonValidationErrors('folders_enabled');
        $this->create(['folders_enabled' => null])->assertJsonValidationErrors('folders_enabled');
    }

    /** @test */
    public function mobile_skin_needs_to_be_a_valid_skin_object()
    {
        $this->create(['mobile_skin' => ['id' => 10]])->assertJsonValidationErrors(['mobile_skin.id']);
        $this->create(['mobile_skin' => ['not-a-valid-skin-object']])->assertJsonValidationErrors(['mobile_skin']);
    }

    /** @test */
    public function tablet_skin_needs_to_be_a_valid_skin_object()
    {
        $this->create(['tablet_skin' => ['id' => 10]])->assertJsonValidationErrors(['tablet_skin.id']);
        $this->create(['tablet_skin' => ['not-a-valid-skin-object']])->assertJsonValidationErrors(['tablet_skin']);
    }

    /** @test */
    public function desktop_skin_needs_to_be_a_valid_skin_object()
    {
        $this->create(['desktop_skin' => ['id' => 10]])->assertJsonValidationErrors(['desktop_skin.id']);
        $this->create(['desktop_skin' => ['not-a-valid-skin-object']])->assertJsonValidationErrors(['desktop_skin']);
    }

    /** @test */
    public function mobile_skin_needs_to_be_a_valid_mobile_object()
    {
        $this->create(['mobile_skin' => ['id' => 10]])->assertJsonValidationErrors(['mobile_skin.id']);
        $this->create(['mobile_skin' => ['not-a-valid-skin-object']])->assertJsonValidationErrors(['mobile_skin']);
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
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['containers.create'])
        );

        return $this->postJson(route('containers.store'), $this->validFields($attributes));
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
            'folders_enabled' => $this->faker->boolean,
            'mobile_skin' => factory(Skin::class)->create(['mobile' => true]),
            'tablet_skin' => factory(Skin::class)->create(['tablet' => true]),
            'desktop_skin' => factory(Skin::class)->create(['desktop' => true]),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
