<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\TemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Tag;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TemplatesController extends Controller
{

    /**
     * TemplatesController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:templates.create')->only(['store']);
        $this->middleware('permission:templates.read')->only(['index', 'show', 'paginated']);
        $this->middleware('permission:templates.update')->only(['update']);
        $this->middleware('permission:templates.delete')->only(['destroy', 'bulkDestroy']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $templates = Template::withRelations($request)->get();

        return response()->json(TemplateResource::collection($templates), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function paginated(Request $request)
    {
        $templates = Template::withRelations($request)->filter($request)->paginate($this->paginationNumber());

        return TemplateResource::collection($templates);
    }

    /**
     * @param TemplateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TemplateRequest $request)
    {
        $template = Template::create($request->validated());

        foreach ($request->get('tags', []) as $tag) {
            $template->tags()->attach(Tag::find($tag['id']));
        }

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
        $template->fill($request->validated())->save();

        $template->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $template->tags()->attach(Tag::find($tag['id']));
        }

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
