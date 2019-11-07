<?php

namespace Tests\Feature\Tokens;

use App\Models\Role;
use App\Models\Token;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokensCreateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_cannot_create_tokens()
    {
        $this->postJson(route('tokens.store'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_without_create_permission_cannot_create_tokens()
    {
        $this->signIn();

        $this->postJson(route('tokens.store'))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_with_create_permission_can_create_tokens()
    {
        $this->withoutExceptionHandling();

        $this->create()->assertStatus(201);
        $tokens = Token::all();
        $this->assertCount(1, $tokens);

        $token = $tokens->first();
        $this->assertNotEmpty($token->api_token);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $this->create(['name' => null])->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_valid_role()
    {
        $this->create(['role' => null])->assertJsonValidationErrors('role');
        $this->create(['role' => 'not-a-valid-role'])->assertJsonValidationErrors('role.id');
        $this->create(['role' => ['not-a-valid-role-object']])->assertJsonValidationErrors('role.id');
    }

    /**
     * @param array $attributes
     *
     * @return TestResponse
     */
    protected function create($attributes = [])
    {
        $role = $this->createRoleWithPermissions(['token:create']);

        $this->signIn(null, $role);

        return $this->postJson(route('tokens.store'), $this->validFields($attributes));
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
            'role' => factory(Role::class)->create(),
        ], $overrides);
    }
}
