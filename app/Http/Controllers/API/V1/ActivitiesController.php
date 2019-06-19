<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ActivitiesController extends Controller
{

    /**
     * ActionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:activities.read')->only(['index', 'paginated', 'show']);
    }

    /**
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $activities = Activity::query()
            ->filter($request)
            ->get();

        return $this->json(ActivityResource::collection($activities), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $activities = Activity::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return ActivityResource::collection($activities);
    }

    /**
     * @param Activity $activity
     *
     * @return JsonResponse
     */
    public function show(Activity $activity)
    {
        return $this->json(new ActivityResource($activity), Response::HTTP_OK);
    }
}
