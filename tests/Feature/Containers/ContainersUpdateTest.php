<?php

namespace Tests\Feature\Containers;

use App\Models\Category;
use App\Models\Container;
use App\Models\Skin;
use App\Models\Tag;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContainersUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_containers()
    {
        $container = factory(Container::class)->create();

        $this->putJson(route('containers.update', ['container' => $container]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_update_permission_cannot_update_containers()
    {
        $this->signIn();

        $container = factory(Container::class)->create();

        $this->putJson(route('containers.update', ['container' => $container]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_containers()
    {
        $container = factory(Container::class)->create();

        $attributes = ['id' => $container->id, 'name' => $this->faker->name];

        $this->update($container, $attributes)->assertOk();

        $this->assertDatabaseHas('containers', $attributes);
    }

    /**
     * @param $container
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($container, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['container:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('containers.update', ['container' => $container]), $this->validFields($attributes));
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
            'mobile_skin' => factory(Skin::class)->create(),
            'tablet_skin' => factory(Skin::class)->create(),
            'desktop_skin' => factory(Skin::class)->create(),
            'category' => factory(Category::class)->create(),
            'tags' => factory(Tag::class, 2)->create()
        ], $overrides);
    }
}
