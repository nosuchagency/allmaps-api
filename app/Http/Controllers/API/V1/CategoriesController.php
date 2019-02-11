<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{

    /**
     * Instantiate controller
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:categories.create')->only(['store']);
        $this->middleware('permission:categories.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:categories.update')->only(['update']);
        $this->middleware('permission:categories.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json(CategoryResource::collection($categories), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $categories = Category::filter($request)->paginate($this->paginationNumber());

        return CategoryResource::collection($categories);
    }

    /**
     * @param CategoryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json(new CategoryResource($category), Response::HTTP_CREATED);
    }

    /**
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return response()->json(new CategoryResource($category), Response::HTTP_OK);
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->validated())->save();

        return response()->json(new CategoryResource($category), Response::HTTP_OK);
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

        return response()->json(null, Response::HTTP_OK);
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

        return response()->json(null, Response::HTTP_OK);
    }
}
