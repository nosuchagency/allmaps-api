<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Container;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContainerService implements ModelServiceContract
{
    /**
     * @param Request $request
     *
     * @return Model
     */
    public function create(Request $request)
    {
        $container = new Container();

        $container->fill($request->only($container->getFillable()));

        $this->setSkins($container, $request);

        $container->save();

        foreach ($request->get('tags', []) as $tag) {
            $container->tags()->attach(Tag::find($tag['id']));
        }

        return $container->refresh();
    }

    /**
     * @param Model $container
     * @param Request $request
     *
     * @return Model
     */
    public function update(Model $container, Request $request)
    {
        $container->fill($request->only($container->getFillable()));
        $this->setSkins($container, $request);
        $container->save();

        $container->tags()->sync([]);

        foreach ($request->get('tags', []) as $tag) {
            $container->tags()->attach(Tag::find($tag['id']));
        }

        return $container->refresh();
    }

    /**
     * @param $container
     * @param Request $request
     */
    private function setSkins($container, Request $request)
    {
        if ($request->has('mobile_skin')) {
            $container->mobileSkin()->associate(
                $request->input('mobile_skin.id')
            );
        }

        if ($request->has('tablet_skin')) {
            $container->tabletSkin()->associate(
                $request->input('tablet_skin.id')
            );
        }

        if ($request->has('desktop_skin')) {
            $container->desktopSkin()->associate(
                $request->input('desktop_skin.id')
            );
        }
    }
}