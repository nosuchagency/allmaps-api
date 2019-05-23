<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var string
     */
    protected $password;

    protected function setUp(): void
    {
        parent::setUp();
        $this->password = $this->faker->password(8);
    }

    /** @test */
    public function a_guest_can_log_in()
    {
        $user = factory(User::class)->create([
            'password' => $this->password
        ]);

        $this->postJson(route('login'), ['email' => $user->email, 'password' => $this->password])
            ->assertOk()
            ->assertHeader('Authorization');
    }

    /** @test */
    public function login_requires_a_valid_filled_email()
    {
        $this->postJson(route('login'), ['email' => null, 'password' => $this->password])->assertJsonValidationErrors('email');
        $this->postJson(route('login'), ['email' => 'not-a-valid-email', 'password' => $this->password])->assertJsonValidationErrors('email');
    }

    /** @test */
    public function login_requires_a_filled_password()
    {
        $this->postJson(route('login'), ['email' => 'example@gmail.com', 'password' => null])->assertJsonValidationErrors('password');
    }
}
