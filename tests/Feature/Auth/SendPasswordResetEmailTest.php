<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendPasswordResetEmailTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_guest_can_trigger_reset_password_email_if_user_exists()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $this->postJson(route('password.email'), ['email' => $user->email])
            ->assertOk()
            ->assertJsonFragment([
                'status' => true
            ]);;

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    /** @test */
    public function a_guest_cant_trigger_rest_password_email_if_user_does_not_exists()
    {
        Notification::fake();

        $this->postJson(route('password.email'), ['email' => $this->faker->email])
            ->assertOk()
            ->assertJsonFragment([
                'status' => false
            ]);

        Notification::assertNothingSent();
    }
}
