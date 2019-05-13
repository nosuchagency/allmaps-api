<?php

namespace Tests\Feature\Beacons;

use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->password = $this->faker->password(8);
    }

    /** @test */
    public function a_guest_can_reset_password_for_user_with_valid_token_and_email()
    {
        $this->assertFalse(Hash::check($this->password, $this->user->password));

        $this->send()
            ->assertOk()
            ->assertJsonFragment([
                'status' => true
            ]);

        $this->assertTrue(Hash::check($this->password, $this->user->refresh()->password));
    }

    /** @test */
    public function password_reset_fails_if_email_is_invalid_or_does_not_exist()
    {
        $this->send(['email' => 'not-a-valid-email'])
            ->assertJsonValidationErrors('email');

        $this->send(['email' => 'test@gmail.com'])
            ->assertJsonFragment([
                'status' => false
            ]);
    }

    /** @test */
    public function password_reset_fails_with_status_false_if_token_is_invalid()
    {
        $this->send(['token' => '-invalid'])
            ->assertJsonFragment([
                'status' => false
            ]);
    }

    /**
     * @param array $attributes
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function send($attributes = [])
    {
        return $this->postJson(route('password.reset'), $this->validFields($attributes));
    }

    /**
     * @param array $overrides
     *
     * @return array
     */
    protected function validFields($overrides = [])
    {
        return array_merge([
            'token' => $token = app(PasswordBroker::class)->createToken($this->user),
            'email' => $this->user->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ], $overrides);
    }
}
