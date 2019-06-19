<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\LayoutRequest;
use App\Http\Resources\LayoutResource;
use App\Models\Layout;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LayoutsController extends Controller
{

    /**
     * LayoutsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:layouts.create')->only(['store']);
        $this->middleware('permission:layouts.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:layouts.update')->only(['update']);
        $this->middleware('permission:layouts.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $layouts = Layout::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(LayoutResource::collection($layouts), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $layouts = Layout::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return LayoutResource::collection($layouts);
    }

    /**
     * @param LayoutRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Layout $layout)
    {
        $layout->load($layout->relationships);

        return $this->json(new LayoutResource($layout), Response::HTTP_OK);
    }

    /**
     * @param LayoutRequest $request
     * @param Layout $layout
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Layout $layout)
    {
        $layout->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($layout) {
            if ($layoutToDelete = Layout::find($layout['id'])) {
                $layoutToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
