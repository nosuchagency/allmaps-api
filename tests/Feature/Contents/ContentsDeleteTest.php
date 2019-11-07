<?php

namespace Tests\Feature\Contents;

use App\Models\Content\Content;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContentsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_contents()
    {
        $this->postJson(route('contents.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('contents.destroy', ['content' => factory(Content::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_contents()
    {
        $this->signIn();
        $content = factory(Content::class)->create();
        $this->deleteJson(route('contents.destroy', ['content' => $content]))->assertStatus(403);

        $this->postJson(route('contents.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_content()
    {
        $role = $this->createRoleWithPermissions(['content:delete']);

        $this->signIn(null, $role);

        $content = factory(Content::class)->create();
        $this->deleteJson(route('contents.destroy', ['content' => $content]))->assertOk();
        $this->assertSoftDeleted('contents', ['id' => $content->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_contents_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['content:delete']);

        $this->signIn(null, $role);

        $contents = factory(Content::class, 5)->create();
        $this->assertCount(5, Content::all());
        $this->postJson(route('contents.bulk-destroy'), ['items' => $contents])->assertOk();
        $this->assertCount(0, Content::all());
    }
}
