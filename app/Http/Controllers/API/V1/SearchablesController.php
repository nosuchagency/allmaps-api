<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchableRequest;
use App\Http\Resources\SearchableResource;
use App\Models\Searchable;
use App\Plugins\Search\SearchableResolver;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SearchablesController extends Controller
{

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index()
    {
        $this->authorize('viewAny', Searchable::class);

        $searchables = Searchable::active()->get();

        return $this->json(SearchableResource::collection($searchables), Response::HTTP_OK);
    }

    /**
     * @param SearchableRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(SearchableRequest $request)
    {
        $searchable = Searchable::create($request->validated());

        return $this->json(new SearchableResource($searchable), Response::HTTP_CREATED);
    }

    /**
     * @param Searchable $searchable
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Searchable $searchable)
    {
        $this->authorize('view', Searchable::class);

        return $this->json(new SearchableResource($searchable), Response::HTTP_OK);
    }

    /**
     * @param SearchableRequest $request
     * @param Searchable $searchable
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(SearchableRequest $request, Searchable $searchable)
    {
        $searchable->fill($request->validated())->save();

        return $this->json(new SearchableResource($searchable), Response::HTTP_OK);
    }

    /**
     * @param Searchable $searchable
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Searchable $searchable)
    {
        $this->authorize('delete', Searchable::class);

        $searchable->delete();

        return $this->json(null, Response::HTTP_OK);
    }
}
