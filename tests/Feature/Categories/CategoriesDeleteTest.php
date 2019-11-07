<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_categories()
    {
        $this->postJson(route('categories.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('categories.destroy', ['category' => factory(Category::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_categories()
    {
        $this->signIn();
        $category = factory(Category::class)->create();
        $this->deleteJson(route('categories.destroy', ['category' => $category]))->assertStatus(403);

        $this->postJson(route('categories.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_category()
    {
        $role = $this->createRoleWithPermissions(['category:delete']);

        $this->signIn(null, $role);

        $category = factory(Category::class)->create();
        $this->deleteJson(route('categories.destroy', ['category' => $category]))->assertOk();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_categories_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['category:delete']);

        $this->signIn(null, $role);

        $categories = factory(Category::class, 5)->create();
        $this->assertCount(5, Category::all());
        $this->postJson(route('categories.bulk-destroy'), ['items' => $categories])->assertOk();
        $this->assertCount(0, Category::all());
    }
}
