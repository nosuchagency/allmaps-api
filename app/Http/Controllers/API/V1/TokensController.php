<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\TokenResource;
use App\Models\Token;
use App\Services\Models\TokenService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TokensController extends Controller
{

    /**
     * @var TokenService
     */
    protected $tokenService;

    /**
     * TokensController constructor.
     *
     * @param TokenService $tokenService
     */
    public function __construct(TokenService $tokenService)
    {
        $this->middleware('permission:tokens.create')->only(['store']);
        $this->middleware('permission:tokens.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:tokens.update')->only(['update']);
        $this->middleware('permission:tokens.delete')->only(['destroy', 'bulkDestroy']);

        $this->tokenService = $tokenService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $tokens = Token::query()
            ->filter($request)
            ->get();

        return response()->json(TokenResource::collection($tokens), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $tokens = Token::query()
            ->filter($request)
            ->paginate($this->paginationNumber());

        return TokenResource::collection($tokens);
    }

    /**
     * @param TokenRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TokenRequest $request)
    {
        $token = $this->tokenService->create($request);

        return response()->json(new TokenResource($token), Response::HTTP_CREATED);
    }

    /**
     * @param Token $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Token $token)
    {
        return response()->json(new TokenResource($token), Response::HTTP_OK);
    }

    /**
     * @param TokenRequest $request
     * @param Token $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TokenRequest $request, Token $token)
    {
        $token = $this->tokenService->update($token, $request);

        return response()->json(new TokenResource($token), Response::HTTP_OK);
    }

    /**
     * @param Token $token
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Token $token)
    {
        $token->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($token) {
            if ($tokenToDelete = Token::find($token['id'])) {
                $tokenToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
