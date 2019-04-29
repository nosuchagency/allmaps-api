<?php

namespace Tests\Feature\Beacons;

use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_can_reset_password_for_user_with_valid_token_and_email()
    {
        $this->send()
            ->assertOk()
            ->assertJsonFragment([
                'status' => true
            ]);
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
        $user = factory(User::class)->create();

        return array_merge([
            'token' => $token = app(PasswordBroker::class)->createToken($user),
            'email' => $user->email,
            'password' => 'newpassword12',
            'password_confirmation' => 'newpassword12',
        ], $overrides);
    }
}
