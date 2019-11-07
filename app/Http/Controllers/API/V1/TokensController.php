<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Resources\TokenResource;
use App\Models\Token;
use App\Services\Models\TokenService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $this->tokenService = $tokenService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Token::class);

        $tokens = Token::query()
            ->filter($request)
            ->get();

        return $this->json(TokenResource::collection($tokens), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Token::class);

        $tokens = Token::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return TokenResource::collection($tokens);
    }

    /**
     * @param TokenRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(TokenRequest $request)
    {
        $token = $this->tokenService->create($request->validated());

        return $this->json(new TokenResource($token), Response::HTTP_CREATED);
    }

    /**
     * @param Token $token
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Token $token)
    {
        $this->authorize('view', Token::class);

        return $this->json(new TokenResource($token), Response::HTTP_OK);
    }

    /**
     * @param TokenRequest $request
     * @param Token $token
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(TokenRequest $request, Token $token)
    {
        $token = $this->tokenService->update($token, $request->validated());

        return $this->json(new TokenResource($token), Response::HTTP_OK);
    }

    /**
     * @param Token $token
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Token $token)
    {
        $this->authorize('delete', Token::class);

        $token->delete();

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
        $this->authorize('delete', Token::class);

        collect($request->get('items'))->each(function ($token) {
            if ($tokenToDelete = Token::find($token['id'])) {
                $tokenToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
