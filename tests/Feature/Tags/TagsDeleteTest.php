<?php

namespace Tests\Feature\Tags;

use App\Models\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagsDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_tags()
    {
        $this->postJson(route('tags.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('tags.destroy', ['tag' => factory(Tag::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_tags()
    {
        $this->signIn();
        $tag = factory(Tag::class)->create();
        $this->deleteJson(route('tags.destroy', ['tag' => $tag]))->assertStatus(403);

        $this->postJson(route('tags.bulk-destroy'), ['items' => []])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_tag()
    {
        $role = $this->createRoleWithPermissions(['tag:delete']);

        $this->signIn(null, $role);

        $tag = factory(Tag::class)->create();
        $this->deleteJson(route('tags.destroy', ['tag' => $tag]))->assertOk();
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_tags_in_bulk()
    {
        $role = $this->createRoleWithPermissions(['tag:delete']);

        $this->signIn(null, $role);

        $tags = factory(Tag::class, 5)->create();
        $this->assertCount(5, Tag::all());
        $this->postJson(route('tags.bulk-destroy'), ['items' => $tags])->assertOk();
        $this->assertCount(0, Tag::all());
    }
}
