<?php

namespace Tests\Unit\Models;

use App\Models\Token;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class TokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_token_has_actions()
    {
        $token = factory(Token::class)->create();
        $this->assertInstanceOf(Collection::class, $token->actions);
    }
}
