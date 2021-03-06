<?php

namespace Tests\Feature\Tokens;

use App\Models\Role;
use App\Models\Token;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokensUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_update_tokens()
    {
        $token = factory(Token::class)->create();

        $this->putJson(route('tokens.update', ['token' => $token]))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_update_tokens()
    {
        $this->signIn();

        $token = factory(Token::class)->create();

        $this->putJson(route('tokens.update', ['token' => $token]))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_update_permission_can_update_tokens()
    {
        $token = factory(Token::class)->create();

        $attributes = ['id' => $token->id, 'name' => $this->faker->name];

        $this->update($token, $attributes)->assertOk();

        $this->assertDatabaseHas('tokens', $attributes);
    }

    /**
     * @param $token
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function update($token, $attributes = [])
    {
        $role = $this->createRoleWithPermissions(['token:update']);

        $this->signIn(null, $role);

        return $this->putJson(route('tokens.update', ['token' => $token]), $this->validFields($attributes));
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
            'role' => factory(Role::class)->create()
        ], $overrides);
    }
}
