<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PermissionsController extends Controller
{

    /**
     *
     * @return JsonResponse
     */
    public function index()
    {
        $permissions = Permission::all();

        return $this->json($permissions, Response::HTTP_OK);
    }
}
