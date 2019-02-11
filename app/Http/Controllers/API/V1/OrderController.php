<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Content\Content;
use App\Models\Folder;
use Illuminate\Http\Response;

class OrderController extends Controller
{

    /**
     * FloorsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:folders.update')->only(['folders']);
        $this->middleware('permission:contents.update')->only(['contents']);
    }

    /**
     * @param OrderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function folders(OrderRequest $request)
    {
        collect($request->get('items'))->each(function ($value, $key) {
            Folder::find($value)->update(['order' => $key]);
        });

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param OrderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function contents(OrderRequest $request)
    {
        collect($request->get('items'))->each(function ($value, $key) {
            Content::find($value)->update(['order' => $key]);
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
