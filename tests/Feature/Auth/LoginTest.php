<?php

namespace Tests\Feature\Beacons;

use App\Models\Beacon;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_can_log_in()
    {
        $user = factory(User::class)->create();

        $this->postJson(route('login'), ['email' => $user->email, 'password' => 'secret'])
            ->assertStatus(200)
            ->assertHeader('Authorization');
    }

    /** @test */
    public function login_requires_a_valid_filled_email()
    {
        $this->postJson(route('login'), ['email' => null, 'password' => 'secret'])->assertJsonValidationErrors('email');
        $this->postJson(route('login'), ['email' => 'not-a-valid-email', 'password' => 'secret'])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function login_requires_a_filled_password()
    {
        $this->postJson(route('login'), ['email' => 'example@gmail.com', 'password' => null])->assertJsonValidationErrors('password');
    }
}
