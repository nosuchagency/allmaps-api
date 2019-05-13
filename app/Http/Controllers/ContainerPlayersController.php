<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Services\SkinHandler;
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

        $skinHandler = new SkinHandler($skin);

        if (!$skinHandler->hasContent() || !$skinHandler->hasDataKey()) {
            return response()->view('errors.404', [], 404);
        }

        return $skinHandler->injectContainerData($container);
    }
}
