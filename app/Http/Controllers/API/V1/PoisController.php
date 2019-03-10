<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\PoiRequest;
use App\Http\Resources\PoiResource;
use App\Models\Poi;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PoisController extends Controller
{

    /**
     * PoisController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:pois.create')->only(['store']);
        $this->middleware('permission:pois.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:pois.update')->only(['update']);
        $this->middleware('permission:pois.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $pois = Poi::withRelations($request)->get();

        return response()->json(PoiResource::collection($pois), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $pois = Poi::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return PoiResource::collection($pois);
    }

    /**
     * @param PoiRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PoiRequest $request)
    {
        $poi = Poi::create($request->except('image'));
        $poi->addAndSaveImage($request->get('image'));

        foreach ($request->get('tags') as $tag) {
            $poi->tags()->attach(Tag::find($tag['id']));
        }

        $poi->load($poi->relations);

        return response()->json(new PoiResource($poi), Response::HTTP_CREATED);
    }

    /**
     * @param Poi $poi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Poi $poi)
    {
        $poi->load($poi->relations);

        return response()->json(new PoiResource($poi), Response::HTTP_OK);
    }

    /**
     * @param Poi $poi
     * @param PoiRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Poi $poi, PoiRequest $request)
    {
        $poi->fill($request->except('image'))->save();
        $poi->addAndSaveImage($request->get('image'));

        $poi->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $poi->tags()->attach(Tag::find($tag['id']));
        }

        $poi->load($poi->relations);

        return response()->json(new PoiResource($poi), Response::HTTP_OK);
    }

    /**
     * @param Poi $poi
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Poi $poi)
    {
        $poi->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($poi) {
            if ($poiToDelete = Poi::find($poi['id'])) {
                $poiToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
