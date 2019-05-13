<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = Permission::all();

        return response()->json($permissions, Response::HTTP_OK);
    }
}
