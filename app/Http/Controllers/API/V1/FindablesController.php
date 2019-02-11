<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FindableRequest;
use App\Http\Resources\FindableResource;
use App\Models\Findable;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FindablesController extends Controller
{

    /**
     * FindablesController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:findables.create')->only(['store']);
        $this->middleware('permission:findables.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:findables.update')->only(['update']);
        $this->middleware('permission:findables.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $findables = Findable::withRelations($request)->get();

        return response()->json(FindableResource::collection($findables), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $findables = Findable::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return FindableResource::collection($findables);
    }

    /**
     * @param FindableRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FindableRequest $request)
    {
        $findable = Findable::create($request->validated());

        foreach ($request->get('tags') as $tag) {
            $findable->tags()->attach(Tag::find($tag['id']));
        }

        $findable->load($findable->relations);

        return response()->json(new FindableResource($findable), Response::HTTP_CREATED);
    }

    /**
     * @param Findable $findable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Findable $findable)
    {
        $findable->load($findable->relations);

        return response()->json(new FindableResource($findable), Response::HTTP_OK);
    }

    /**
     * @param FindableRequest $request
     * @param Findable $findable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FindableRequest $request, Findable $findable)
    {
        $findable->fill($request->validated())->save();

        $findable->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $findable->tags()->attach(Tag::find($tag['id']));
        }

        $findable->load($findable->relations);

        return response()->json(new FindableResource($findable), Response::HTTP_OK);
    }

    /**
     * @param Findable $findable
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Findable $findable)
    {
        $findable->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($findable) {
            if ($findableToDelete = Findable::find($findable['id'])) {
                $findableToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
