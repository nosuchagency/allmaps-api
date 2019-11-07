<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Models\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UsersController extends Controller
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UsersController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(UserResource::collection($users), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = User::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return UserResource::collection($users);
    }

    /**
     * @param UserRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request->validated());

        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);

        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->userService->update($user, $request->validated());

        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param User $user
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);

        $user->delete();

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
        $this->authorize('delete', User::class);

        collect($request->get('items'))->each(function ($user) {
            if ($userToDelete = User::find($user['id'])) {
                $userToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
