<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\LayoutRequest;
use App\Http\Resources\LayoutResource;
use App\Models\Layout;
use App\Models\Tag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LayoutsController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Layout::class);

        $layouts = Layout::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(LayoutResource::collection($layouts), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Layout::class);

        $layouts = Layout::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return LayoutResource::collection($layouts);
    }

    /**
     * @param LayoutRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(LayoutRequest $request)
    {
        $layout = Layout::create($request->validated());

        foreach ($request->get('tags', []) as $tag) {
            $layout->tags()->attach(Tag::find($tag['id']));
        }

        $layout->load($layout->relationships);

        return $this->json(new LayoutResource($layout), Response::HTTP_CREATED);
    }

    /**
     * @param Layout $layout
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Layout $layout)
    {
        $this->authorize('view', Layout::class);

        $layout->load($layout->relationships);

        return $this->json(new LayoutResource($layout), Response::HTTP_OK);
    }

    /**
     * @param LayoutRequest $request
     * @param Layout $layout
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(LayoutRequest $request, Layout $layout)
    {
        $layout->fill($request->validated())->save();

        $layout->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $layout->tags()->attach(Tag::find($tag['id']));
        }

        $layout->load($layout->relationships);

        return $this->json(new LayoutResource($layout), Response::HTTP_OK);
    }

    /**
     * @param Layout $layout
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Layout $layout)
    {
        $this->authorize('delete', Layout::class);

        $layout->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        $this->authorize('delete', Layout::class);

        collect($request->get('items'))->each(function ($layout) {
            if ($layoutToDelete = Layout::find($layout['id'])) {
                $layoutToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
