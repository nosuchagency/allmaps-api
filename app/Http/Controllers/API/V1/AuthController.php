<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * @param  LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $this->logSuccessfulLogin();

        return response()->json(null, Response::HTTP_OK)
            ->header('Authorization', 'Bearer ' . $token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
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