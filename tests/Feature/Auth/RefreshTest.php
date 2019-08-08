<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefreshTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function an_authenticated_user_can_refresh_token()
    {
        $user = $this->signIn();

        $oldToken = auth()->tokenById($user->id);

        $this->postJson(route('refresh'))->assertOk()
            ->assertHeader('Authorization');

        $newToken = auth()->tokenById($user->id);

        $this->assertNotEquals($oldToken, $newToken);
    }

    /** @test */
    public function a_guest_cannot_refresh_token()
    {
        $this->postJson(route('refresh'))->assertStatus(401);
    }
}
