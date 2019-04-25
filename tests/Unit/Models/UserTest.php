<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_tags()
    {
        $user = factory(User::class)->create();
        $this->assertInstanceOf(Collection::class, $user->tags);
    }

    /** @test */
    public function a_user_has_contents()
    {
        $user = factory(User::class)->create();
        $this->assertInstanceOf(Collection::class, $user->contents);
    }

    /** @test */
    public function a_user_has_actions()
    {
        $user = factory(User::class)->create();
        $this->assertInstanceOf(Collection::class, $user->actions);
    }
}
