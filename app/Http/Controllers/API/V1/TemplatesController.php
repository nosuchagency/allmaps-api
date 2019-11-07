<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\TemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use App\Services\Models\TemplateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        $this->templateService = $templateService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Template::class);

        $templates = Template::query()
            ->withRelations($request)
            ->filter($request)
            ->get();

        return $this->json(TemplateResource::collection($templates), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function paginated(Request $request)
    {
        $this->authorize('viewAny', Template::class);

        $templates = Template::query()
            ->withRelations($request)
            ->filter($request)
            ->jsonPaginate($this->paginationNumber());

        return TemplateResource::collection($templates);
    }

    /**
     * @param TemplateRequest $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function store(TemplateRequest $request)
    {
        $template = $this->templateService->create($request);

        $template->load($template->relationships);

        return $this->json(new TemplateResource($template), Response::HTTP_CREATED);
    }

    /**
     * @param Template $template
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Template $template)
    {
        $this->authorize('view', Template::class);

        $template->load($template->relationships);

        return $this->json(new TemplateResource($template), Response::HTTP_OK);
    }

    /**
     * @param TemplateRequest $request
     * @param Template $template
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function update(TemplateRequest $request, Template $template)
    {
        $template = $this->templateService->update($template, $request);

        $template->load($template->relationships);

        return $this->json(new TemplateResource($template), Response::HTTP_OK);
    }

    /**
     * @param Template $template
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Template $template)
    {
        $this->authorize('delete', Template::class);

        $template->delete();

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
        $this->authorize('delete', Template::class);

        collect($request->get('items'))->each(function ($template) {
            if ($templateToDelete = Template::find($template['id'])) {
                $templateToDelete->delete();
            }
        });

        return $this->json(null, Response::HTTP_OK);
    }
}
