<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Content\Content;
use App\Models\Folder;
use App\Models\MenuItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderController extends Controller
{

    /**
     * @param OrderRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function folders(OrderRequest $request)
    {
        $this->authorize('update', Folder::class);

        collect($request->get('items'))->each(function ($value, $key) {
            Folder::find($value)->update(['order' => $key]);
        });

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param OrderRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function contents(OrderRequest $request)
    {
        $this->authorize('update', Content::class);

        collect($request->get('items'))->each(function ($value, $key) {
            Content::find($value)->update(['order' => $key]);
        });

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param OrderRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function menuItems(OrderRequest $request)
    {
        $this->authorize('update', MenuItem::class);

        collect($request->get('items'))->each(function ($value, $key) {
            MenuItem::find($value)->update(['order' => $key]);
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
