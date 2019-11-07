<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Models\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{

    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoriesController constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $categories = Category::query()
            ->filter($request)
            ->get();

        return $this->json(CategoryResource::collection($categories), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $categories = Category::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return CategoryResource::collection($categories);
    }

    /**
     * @param CategoryRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());

        return $this->json(new CategoryResource($category), Response::HTTP_CREATED);
    }

    /**
     * @param Category $category
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Category $category)
    {
        $this->authorize('view', Category::class);

        return $this->json(new CategoryResource($category), Response::HTTP_OK);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = $this->categoryService->update($category, $request->validated());

        return $this->json(new CategoryResource($category), Response::HTTP_OK);
    }

    /**
     * @param Category $category
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', Category::class);

        $category->delete();

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
        $this->authorize('delete', Category::class);

        collect($request->get('items'))->each(function ($category) {
            if ($categoryToDelete = Category::find($category['id'])) {
                $categoryToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
