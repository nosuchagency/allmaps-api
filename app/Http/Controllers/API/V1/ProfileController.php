<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = auth()->user();

        return response()->json(new ProfileResource($user), Response::HTTP_OK);
    }

    /**
     * @param ProfileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->fill($request->except('password', 'role'));
        $user->assignRole($request->get('role'));

        if ($password = $request->get('password')) {
            $user->password = Hash::make($password);
        }

        $user->save();

        return response()->json(new ProfileResource($user), Response::HTTP_OK);
    }
}
