<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ActivitiesController extends Controller
{

    /**
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Activity::class);

        $activities = Activity::query()
            ->filter($request)
            ->get();

        return $this->json(ActivityResource::collection($activities), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Activity::class);

        $activities = Activity::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ActivityResource::collection($activities);
    }

    /**
     * @param Activity $activity
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Activity $activity)
    {
        $this->authorize('view', Activity::class);

        return $this->json(new ActivityResource($activity), Response::HTTP_OK);
    }
}
