<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Models\CategoryService;
use Illuminate\Http\Request;
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
        $this->middleware('permission:categories.create')->only(['store']);
        $this->middleware('permission:categories.read')->only(['index', 'paginated', 'show']);
        $this->middleware('permission:categories.update')->only(['update']);
        $this->middleware('permission:categories.delete')->only(['destroy', 'bulkDestroy']);

        $this->categoryService = $categoryService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            ->filter($request)
            ->get();

        return $this->json(CategoryResource::collection($categories), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $categories = Category::query()
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return CategoryResource::collection($categories);
    }

    /**
     * @param CategoryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->create($request);

        return $this->json(new CategoryResource($category), Response::HTTP_CREATED);
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->json(new CategoryResource($category), Response::HTTP_OK);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = $this->categoryService->update($category, $request);

        return $this->json(new CategoryResource($category), Response::HTTP_OK);
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($category) {
            if ($categoryToDelete = Category::find($category['id'])) {
                $categoryToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
