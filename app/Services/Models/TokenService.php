<?php

namespace App\Services\Models;

use App\Models\Role;
use App\Models\Token;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TokenService
{
    /**
     * @param array $attributes
     *
     * @return Token
     */
    public function create(array $attributes): Token
    {
        $token = new Token();

        $fields = Arr::only($attributes, [
            'name',
        ]);

        $token->fill(
            Arr::add($fields, 'api_token', Str::random(60))
        );

        $token->role()->associate(
            Role::find(Arr::get($attributes, 'role.id'))
        );

        $token->save();

        return $token->refresh();
    }

    /**
     * @param array $attributes
     * @param Token $token
     *
     * @return Token
     */
    public function update(Token $token, array $attributes): Token
    {
        $fields = Arr::only($attributes, [
            'name',
        ]);

        $token->fill($fields);

        if (Arr::has($attributes, 'role.id')) {
            $token->role()->associate(
                Role::find(Arr::get($attributes, 'role.id'))
            );
        }

        $token->save();

        return $token->refresh();
    }
}
