<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Token;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TokenService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $token = new Token();
        $token->fill($request->only($token->getFillable()));
        $token->syncRoles($request->input('role.id'));
        $token->generateToken();
        $token->save();

        return $token->refresh();
    }

    /**
     * @param Request $request
     * @param Model $token
     *
     * @return Model
     */
    public function update(Model $token, Request $request)
    {
        $token->fill($request->only($token->getFillable()));
        $token->syncRoles($request->input('role.id'));
        $token->save();

        return $token->refresh();
    }
}