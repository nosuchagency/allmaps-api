<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\FixtureRequest;
use App\Http\Resources\FixtureResource;
use App\Models\Fixture;
use App\Services\FixtureService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FixturesController extends Controller
{

    protected $fixtureService;

    /**
     * FixturesController constructor.
     *
     * @param FixtureService $fixtureService
     */
    public function __construct(FixtureService $fixtureService)
    {
        $this->middleware('permission:fixtures.create')->only(['store']);
        $this->middleware('permission:fixtures.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:fixtures.update')->only(['update']);
        $this->middleware('permission:fixtures.delete')->only(['destroy', 'bulkDestroy']);

        $this->fixtureService = $fixtureService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $fixtures = Fixture::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return response()->json(FixtureResource::collection($fixtures), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $fixtures = Fixture::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return FixtureResource::collection($fixtures);
    }

    /**
     * @param FixtureRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FixtureRequest $request)
    {
        $fixture = $this->fixtureService->create($request);

        $fixture->load($fixture->relationships);

        return response()->json(new FixtureResource($fixture), Response::HTTP_CREATED);
    }

    /**
     * @param Fixture $fixture
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Fixture $fixture)
    {
        $fixture->load($fixture->relationships);

        return response()->json(new FixtureResource($fixture), Response::HTTP_OK);
    }

    /**
     * @param FixtureRequest $request
     * @param Fixture $fixture
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FixtureRequest $request, Fixture $fixture)
    {
        $fixture = $this->fixtureService->update($request, $fixture);

        $fixture->load($fixture->relationships);

        return response()->json(new FixtureResource($fixture), Response::HTTP_OK);
    }

    /**
     * @param Fixture $fixture
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Fixture $fixture)
    {
        $fixture->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($fixture) {
            if ($fixtureToDelete = Fixture::find($fixture['id'])) {
                $fixtureToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
