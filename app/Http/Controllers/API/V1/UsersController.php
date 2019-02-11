<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:users.create')->only(['store']);
        $this->middleware('permission:users.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:users.update')->only(['update']);
        $this->middleware('permission:users.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::withRelations($request)->get();

        return response()->json(UserResource::collection($users), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $users = User::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return UserResource::collection($users);
    }

    /**
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $user = new User($request->only('name', 'email'));
        $user->assignRole($request->get('role'));

        if ($password = $request->get('password')) {
            $user->password = Hash::make($password);
        }

        $user->save();

        foreach ($request->get('tags') as $tag) {
            $user->tags()->attach(Tag::find($tag['id']));
        }

        $user->load($user->relations);

        return response()->json(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $user->load($user->relations);

        return response()->json(new UserResource($user), Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(User $user, UserRequest $request)
    {
        $user->fill($request->only('name', 'email'));

        if ($password = $request->get('password')) {
            $user->password = Hash::make($password);
        }
        $user->syncRoles($request->get('role'));
        $user->save();

        $user->tags()->sync([]);

        foreach ($request->get('tags') as $tag) {
            $user->tags()->attach(Tag::find($tag['id']));
        }

        $user->load($user->relations);

        return response()->json(new UserResource($user), Response::HTTP_OK);
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

        return response()->json(null, Response::HTTP_OK);
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

        return response()->json(null, Response::HTTP_OK);
    }
}
