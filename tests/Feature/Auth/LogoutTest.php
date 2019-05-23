<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function an_authenticated_can_logout()
    {
        $this->signIn();

        $this->postJson(route('logout'))->assertOk();
    }

    /** @test */
    public function a_guest_cannot_logout()
    {
        $this->postJson(route('logout'))->assertStatus(401);
    }
}
