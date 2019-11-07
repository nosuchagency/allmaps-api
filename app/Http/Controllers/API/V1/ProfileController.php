<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProfileController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function show()
    {
        $user = auth()->user();

        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_OK);
    }
}
