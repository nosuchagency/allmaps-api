<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchableRequest;
use App\Http\Resources\SearchableResource;
use App\Models\Searchable;
use App\Plugins\Search\SearchableResolver;
use Illuminate\Http\Response;

class SearchablesController extends Controller
{
    /**
     * @var SearchableResolver
     */
    protected $resolver;

    /**
     * SearchablesController constructor.
     *
     * @param SearchableResolver $resolver
     */
    public function __construct(SearchableResolver $resolver)
    {
        $this->middleware('permission:searchables.create')->only(['store']);
        $this->middleware('permission:searchables.read')->only(['index', 'show']);
        $this->middleware('permission:searchables.update')->only(['update']);
        $this->middleware('permission:searchables.delete')->only(['destroy']);

        $this->resolver = $resolver;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $searchables = Searchable::active()->get();

        return response()->json(SearchableResource::collection($searchables), Response::HTTP_OK);
    }

    /**
     * @param SearchableRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SearchableRequest $request)
    {
        $searchable = Searchable::create($request->validated());

        return response()->json(new SearchableResource($searchable), Response::HTTP_CREATED);
    }

    /**
     * @param Searchable $searchable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Searchable $searchable)
    {
        return response()->json(new SearchableResource($searchable), Response::HTTP_OK);
    }

    /**
     * @param SearchableRequest $request
     * @param Searchable $searchable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SearchableRequest $request, Searchable $searchable)
    {
        $searchable->fill($request->validated())->save();

        return response()->json(new SearchableResource($searchable), Response::HTTP_OK);
    }

    /**
     * @param Searchable $searchable
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Searchable $searchable)
    {
        $searchable->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
