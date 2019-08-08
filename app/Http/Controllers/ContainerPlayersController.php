<?php

namespace App\Http\Controllers;

use App\Models\Container;
use Illuminate\Http\Request;

class ContainerPlayersController extends Controller
{
    /**
     * @param Request $request
     * @param Container $container
     *
     * @return string
     */
    public function show(Request $request, Container $container)
    {
        $skin = $container->getSkin($request->get('type'));

        if (!$skin) {
            return response()->view('errors.404', [], 404);
        }

        if (!$skin->handler()->hasContent()) {
            return response()->view('errors.404', [], 404);
        }

        if (!$skin->handler()->hasDataKey()) {
            return response()->view('errors.404', [], 404);
        }

        return $skin->handler()->injectContainerData($container);
    }
}
