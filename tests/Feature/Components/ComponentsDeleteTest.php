<?php

namespace Tests\Feature\Components;

use App\Models\Component;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ComponentsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_components()
    {
        $this->postJson(route('components.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('components.destroy', ['component' => factory(Component::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_components()
    {
        $this->signIn();
        $component = factory(Component::class)->create();
        $this->deleteJson(route('components.destroy', ['component' => $component]))->assertStatus(403);

        $this->postJson(route('components.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_specific_components()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['components.delete'])
        );

        $component = factory(Component::class)->create();
        $this->deleteJson(route('components.destroy', ['component' => $component]))->assertStatus(200);

        $this->assertSoftDeleted('components', ['id' => $component->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_may_delete_components_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['components.delete'])
        );

        $components = factory(Component::class, 5)->create();
        $this->assertCount(5, Component::all());
        $this->postJson(route('components.bulk-destroy'), ['items' => $components])->assertStatus(200);
        $this->assertCount(0, Component::all());
    }
}
