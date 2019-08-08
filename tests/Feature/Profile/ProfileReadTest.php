<?php

namespace Tests\Feature\Profile;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileReadTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_user_cannot_read_profile()
    {
        $this->getJson(route('profile'))->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_read_profile()
    {
        $this->signIn();

        $this->getJson(route('profile'))->assertOk();
    }
}
