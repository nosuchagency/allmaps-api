<?php

namespace Tests\Feature\Tokens;

use App\Models\Token;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokensReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_read_tokens()
    {
        $token = factory(Token::class)->create();

        $this->getJson(route('tokens.index'))->assertStatus(401);
        $this->getJson(route('tokens.show', ['token' => $token]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_read_permission_cannot_view_tokens()
    {
        $this->signIn();

        $this->getJson(route('tokens.index'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_tokens()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['tokens.read'])
        );

        $this->getJson(route('tokens.index'))->assertStatus(200);
    }

    /** @test */
    public function an_authenticated_user_with_read_permission_can_view_a_specific_token()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['tokens.read'])
        );

        $token = factory(Token::class)->create();

        $this->getJson(route('tokens.show', ['token' => $token]))->assertStatus(200);
    }
}
