<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Models\UserService;
use Illuminate\Http\Request;
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
        $this->middleware('permission:users.create')->only(['store']);
        $this->middleware('permission:users.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:users.update')->only(['update']);
        $this->middleware('permission:users.delete')->only(['destroy', 'bulkDestroy']);

        $this->userService = $userService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(UserResource::collection($users), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $users = User::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return UserResource::collection($users);
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->userService->create($request);

        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param UserRequest $request
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $user = $this->userService->update($user, $request);

        $user->load($user->relationships);

        return $this->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($user) {
            if ($userToDelete = User::find($user['id'])) {
                $userToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
