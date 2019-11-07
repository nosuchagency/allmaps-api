<?php

namespace App\Services\Models;

use App\Models\Category;
use App\Models\Container;
use App\Models\Skin;
use App\Models\Tag;
use Illuminate\Support\Arr;

class ContainerService
{
    /**
     * @param array $attributes
     *
     * @return Container
     */
    public function create(array $attributes): Container
    {
        $container = new Container();

        $fields = Arr::only($attributes, [
            'name',
            'description',
            'folders_enabled',
        ]);

        $container->fill($fields);

        $this->setSkins($container, $attributes);

        if (Arr::has($attributes, 'category')) {
            $container->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $container->save();

        if (Arr::has($attributes, 'tags')) {
            foreach ($attributes['tags'] as $tag) {
                $container->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $container->refresh();
    }

    /**
     * @param Container $container
     * @param array $attributes
     *
     * @return Container
     */
    public function update(Container $container, array $attributes): Container
    {
        $fields = Arr::only($attributes, [
            'name',
            'description',
            'folders_enabled',
        ]);

        $container->fill($fields);

        $this->setSkins($container, $attributes);

        if (Arr::has($attributes, 'category')) {
            $container->category()->associate(
                Category::find(Arr::get($attributes, 'category.id'))
            );
        }

        $container->save();

        if (Arr::has($attributes, 'tags')) {
            $container->tags()->sync([]);

            foreach ($attributes['tags'] as $tag) {
                $container->tags()->attach(Tag::find($tag['id']));
            }
        }

        return $container->refresh();
    }

    /**
     * @param $container
     * @param array $attributes
     */
    private function setSkins(Container $container, array $attributes)
    {
        if (Arr::has($attributes, 'mobile_skin')) {
            $container->mobileSkin()->associate(
                Skin::find(Arr::get($attributes, 'mobile_skin.id'))
            );
        }

        if (Arr::has($attributes, 'tablet_skin')) {
            $container->tabletSkin()->associate(
                Skin::find(Arr::get($attributes, 'tablet_skin.id'))
            );
        }

        if (Arr::has($attributes, 'desktop_skin')) {
            $container->desktopSkin()->associate(
                Skin::find(Arr::get($attributes, 'desktop_skin.id'))
            );
        }
    }
}
