<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_categories()
    {
        $this->postJson(route('categories.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_categories()
    {
        $this->signIn();

        $this->postJson(route('categories.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_categories()
    {
        $this->create()->assertStatus(201);
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function a_category_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function create($attributes = [])
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['categories.create'])
        );

        return $this->postJson(route('categories.store'), $this->validFields($attributes));
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
            'description' => $this->faker->paragraph
        ], $overrides);
    }
}
