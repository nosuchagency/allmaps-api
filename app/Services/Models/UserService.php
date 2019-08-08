<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $user = new User();
        $user->fill($request->only($user->getFillable()));
        $user->password = $request->get('password');
        $user->syncRoles($request->input('role.id'));
        $user->save();

        foreach ($request->get('tags', []) as $tag) {
            $user->tags()->attach(Tag::find($tag['id']));
        }

        return $user->refresh();
    }

    /**
     * @param Request $request
     * @param Model $user
     *
     * @return Model
     */
    public function update(Model $user, Request $request)
    {
        $user->fill($request->only($user->getFillable()));
        $user->syncRoles($request->input('role.id'));

        if ($request->filled('password')) {
            $user->password = $request->get('password');
        }

        $user->save();

        foreach ($request->get('tags', []) as $tag) {
            $user->tags()->attach(Tag::find($tag['id']));
        }

        return $user->refresh();
    }
}