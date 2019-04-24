<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContainerBeaconRuleRequest;
use App\Http\Resources\RuleResource;
use App\Models\Beacon;
use App\Models\Container;
use Illuminate\Http\Response;

class RulesController extends Controller
{

    /**
     * @param Container $container
     * @param Beacon $beacon
     * @param $rule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Container $container, Beacon $beacon, $rule)
    {
        $beacon = $container->beacons()->findOrFail($beacon->id);

        $rule = $beacon->pivot->rules()->findOrFail($rule);

        return response()->json(new RuleResource($rule), Response::HTTP_OK);
    }

    /**
     * @param ContainerBeaconRuleRequest $request
     * @param Container $container
     * @param Beacon $beacon
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ContainerBeaconRuleRequest $request, Container $container, Beacon $beacon)
    {
        $beacon = $container->beacons()->findOrFail($beacon->id);

        $rule = $beacon->pivot->rules()->create($request->validated());

        return response()->json(new RuleResource ($rule), Response::HTTP_CREATED);
    }

    /**
     * @param ContainerBeaconRuleRequest $request
     * @param Container $container
     * @param Beacon $beacon
     * @param $rule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ContainerBeaconRuleRequest $request, Container $container, Beacon $beacon, $rule)
    {
        $beacon = $container->beacons()->findOrFail($beacon->id);

        $rule = $beacon->pivot->rules()->findOrFail($rule);

        $rule->fill($request->validated())->save();

        return response()->json(new RuleResource ($rule), Response::HTTP_OK);
    }

    /**
     * @param Container $container
     * @param Beacon $beacon
     * @param $rule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Container $container, Beacon $beacon, $rule)
    {
        $beacon = $container->beacons()->findOrFail($beacon->id);

        $beacon->pivot->rules()->findOrFail($rule)->delete();

        return response()->json(null, Response::HTTP_OK);
    }
}
