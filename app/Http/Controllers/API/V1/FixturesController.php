<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FixtureRequest;
use App\Http\Resources\FixtureResource;
use App\Models\Fixture;
use App\Services\Models\FixtureService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FixturesController extends Controller
{

    /**
     * @var FixtureService
     */
    protected $fixtureService;

    /**
     * FixturesController constructor.
     *
     * @param FixtureService $fixtureService
     */
    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Fixture::class);

        $fixtures = Fixture::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(FixtureResource::collection($fixtures), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Fixture::class);

        $fixtures = Fixture::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return FixtureResource::collection($fixtures);
    }

    /**
     * @param FixtureRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(FixtureRequest $request)
    {
        $fixture = $this->fixtureService->create($request->validated());

        $fixture->load($fixture->relationships);

        return $this->json(new FixtureResource($fixture), Response::HTTP_CREATED);
    }

    /**
     * @param Fixture $fixture
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Fixture $fixture)
    {
        $this->authorize('view', Fixture::class);

        $fixture->load($fixture->relationships);

        return $this->json(new FixtureResource($fixture), Response::HTTP_OK);
    }

    /**
     * @param FixtureRequest $request
     * @param Fixture $fixture
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(FixtureRequest $request, Fixture $fixture)
    {
        $fixture = $this->fixtureService->update($fixture, $request->validated());

        $fixture->load($fixture->relationships);

        return $this->json(new FixtureResource($fixture), Response::HTTP_OK);
    }

    /**
     * @param Fixture $fixture
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Fixture $fixture)
    {
        $this->authorize('delete', Fixture::class);

        $fixture->delete();

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
        $this->authorize('delete', Fixture::class);

        collect($request->get('items'))->each(function ($fixture) {
            if ($fixtureToDelete = Fixture::find($fixture['id'])) {
                $fixtureToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
