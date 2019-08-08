<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'meta' => ['The given credentials are invalid.'],
            ]);
        }

        $this->logSuccessfulLogin();

        return $this->json(['message' => 'Successfully logged in'], Response::HTTP_OK)
            ->header('Authorization', 'Bearer ' . $token);
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->json(['message' => 'Refresh successful'], Response::HTTP_OK)
            ->header('Authorization', 'Bearer ' . auth()->refresh());
    }

    /**
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

    /**
     * @return void
     */
    protected function logSuccessfulLogin()
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn(auth()->user())
            ->log('logged in');
    }
}
