<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_categories()
    {
        $category = factory(Category::class)->create();

        $this->getJson(route('categories.index'))->assertStatus(401);
        $this->getJson(route('categories.show', ['category' => $category]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_categories()
    {
        $this->signIn();

        $this->getJson(route('categories.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_categories()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['categories.read'])
        );

        $this->getJson(route('categories.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_category()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['categories.read'])
        );

        $category = factory(Category::class)->create();

        $this->getJson(route('categories.show', ['category' => $category]))->assertOk();
    }
}
