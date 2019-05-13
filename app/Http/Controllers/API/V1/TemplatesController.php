<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\TemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use App\Services\Models\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TemplatesController extends Controller
{

    /**
     * @var TemplateService
     */
    protected $templateService;

    /**
     * TemplatesController constructor.
     *
     * @param TemplateService $templateService
     */
    public function __construct(TemplateService $templateService)
    {
        $this->middleware('permission:templates.create')->only(['store']);
        $this->middleware('permission:templates.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:templates.update')->only(['update']);
        $this->middleware('permission:templates.delete')->only(['destroy', 'bulkDestroy']);

        $this->templateService = $templateService;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $templates = Template::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return response()->json(TemplateResource::collection($templates), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $templates = Template::query()
            ->withRelations($request)
            ->filter($request)
            ->paginate($this->paginationNumber());

        return TemplateResource::collection($templates);
    }

    /**
     * @param TemplateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TemplateRequest $request)
    {
        $template = $this->templateService->create($request);

        $template->load($template->relationships);

        return response()->json(new TemplateResource($template), Response::HTTP_CREATED);
    }

    /**
     * @param Template $template
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Template $template)
    {
        $template->load($template->relationships);

        return response()->json(new TemplateResource($template), Response::HTTP_OK);
    }

    /**
     * @param TemplateRequest $request
     * @param Template $template
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TemplateRequest $request, Template $template)
    {
        $template = $this->templateService->update($template, $request);

        $template->load($template->relationships);

        return response()->json(new TemplateResource($template), Response::HTTP_OK);
    }

    /**
     * @param Template $template
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Template $template)
    {
        $template->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * @param BulkDeleteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDestroy(BulkDeleteRequest $request)
    {
        collect($request->get('items'))->each(function ($template) {
            if ($templateToDelete = Template::find($template['id'])) {
                $templateToDelete->delete();
            }
        });

        return response()->json(null, Response::HTTP_OK);
    }
}
