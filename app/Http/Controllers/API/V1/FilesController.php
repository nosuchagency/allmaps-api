<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class FilesController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file'
        ]);

        $path = $request->file('file')->store('files', 'public');

        return $this->json(['path' => $path], Response::HTTP_CREATED);
    }
}
