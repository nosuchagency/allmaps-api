<?php

namespace Tests\Feature\Hits;

use App\Models\Hit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HitsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_hits()
    {
        $this->postJson(route('hits.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('hits.destroy', ['hit' => factory(Hit::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_hits()
    {
        $this->signIn();
        $hit = factory(Hit::class)->create();
        $this->deleteJson(route('hits.destroy', ['hit' => $hit]))->assertStatus(403);

        $this->postJson(route('hits.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_hit()
    {
        $role = $this->createRoleWithPermissions(['hit:delete']);

        $this->signIn(null, $role);

        $hit = factory(Hit::class)->create();
        $this->deleteJson(route('hits.destroy', ['hit' => $hit]))->assertOk();
        $this->assertSoftDeleted('hits', ['id' => $hit->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_hits_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['hit:delete']);

        $this->signIn(null, $role);

        $hits = factory(Hit::class, 5)->create();
        $this->assertCount(5, Hit::all());
        $this->postJson(route('hits.bulk-destroy'), ['items' => $hits])->assertOk();
        $this->assertCount(0, Hit::all());
    }
}
