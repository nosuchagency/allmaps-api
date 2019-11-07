<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_categories()
    {
        $category = factory(Category::class)->create();

        $this->putJson(route('categories.update', ['category' => $category]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_update_permission_cannot_update_categories()
    {
        $this->signIn();

        $category = factory(Category::class)->create();

        $this->putJson(route('categories.update', ['category' => $category]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_categories()
    {
        $category = factory(Category::class)->create();

        $attributes = ['id' => $category->id, 'name' => $this->faker->name];

        $this->update($category, $attributes)->assertOk();

        $this->assertDatabaseHas('categories', $attributes);
    }

    /**
     * @param $category
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($category, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['category:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('categories.update', ['category' => $category]), $this->validFields($attributes));
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
