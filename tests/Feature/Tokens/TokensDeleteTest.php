<?php

namespace Tests\Feature\Tokens;

use App\Models\Token;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokensDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_delete_tokens()
    {
        $this->postJson(route('tokens.bulk-destroy'))->assertStatus(401);
        $this->deleteJson(route('tokens.destroy', ['token' => factory(Token::class)->create()]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_delete_permission_cannot_delete_tokens()
    {
        $this->signIn();
        $token = factory(Token::class)->create();
        $this->deleteJson(route('tokens.destroy', ['token' => $token]))->assertStatus(403);

        $this->postJson(route('tokens.bulk-destroy', ['items' => []]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_specific_token()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['tokens.delete'])
        );

        $token = factory(Token::class)->create();
        $this->deleteJson(route('tokens.destroy', ['token' => $token]))->assertOk();
        $this->assertDatabaseMissing('tokens', ['id' => $token->id]);
    }

    /** @test */
    public function an_authenticated_user_with_delete_permission_can_delete_tokens_in_bulk()
    {
        $this->signIn()->assignRole(
            $this->createRoleWithPermissions(['tokens.delete'])
        );

        $tokens = factory(Token::class, 5)->create();
        $this->assertCount(5, Token::all());
        $this->postJson(route('tokens.bulk-destroy'), ['items' => $tokens])->assertOk();
        $this->assertCount(0, Token::all());
    }
}
