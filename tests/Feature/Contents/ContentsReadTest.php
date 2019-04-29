<?php

namespace Tests\Feature\Contents;

use App\Models\Content\Content;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContentsReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_contents()
    {
        $content = factory(Content::class)->create();

        $this->getJson(route('contents.index'))->assertStatus(401);
        $this->getJson(route('contents.show', ['content' => $content]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_contents()
    {
        $this->signIn();

        $this->getJson(route('contents.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_contents()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['contents.read'])
        );

        $this->getJson(route('contents.index'))->assertOk();
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_content()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['contents.read'])
        );

        $content = factory(Content::class)->create();

        $this->getJson(route('contents.show', ['content' => $content]))->assertOk();
    }
}
