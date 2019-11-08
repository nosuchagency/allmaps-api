<?php

namespace App\Services\Models;

use App\Models\Skin;
use Chumper\Zipper\Zipper;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SkinService
{

    /**
     * @var Zipper
     */
    protected $zipper;

    /**
     * SkinService constructor.
     */
    public function __construct()
    {
        $this->zipper = new Zipper();
    }


    /**
     * @param array $attributes
     *
     * @return Skin
     * @throws Exception
     */
    public function create(array $attributes): Skin
    {
        $skin = new Skin();

        $fields = Arr::only($attributes, [
            'name',
            'mobile',
            'tablet',
            'desktop'
        ]);

        $skin->fill($fields);
        $skin->identifier = Str::slug($skin->name);
        $this->handleZipFile(Arr::get($attributes, 'file'), $skin->identifier);
        $skin->save();

        return $skin->refresh();
    }

    /**
     * @param Skin $skin
     * @param array $attributes
     *
     * @return Skin
     * @throws Exception
     */
    public function update(Skin $skin, array $attributes): Skin
    {
        $fields = Arr::only($attributes, [
            'name',
            'mobile',
            'tablet',
            'desktop'
        ]);

        $skin->fill($fields)->save();

        if (Arr::has($attributes, 'file')) {
            $this->handleZipFile(Arr::get($attributes, 'file'), $skin->identifier);
        }

        return $skin->refresh();
    }

    /**
     * @param $file
     * @param $directory
     *
     * @throws Exception
     */
    private function handleZipFile($file, $directory)
    {
        $path = public_path(config('all-maps.skins.directory') . $directory);
        $this->zipper->make($file)->extractTo($path, []);
    }
}
