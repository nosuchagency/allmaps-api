<?php

namespace App\Services\Models;

use App\Models\Skin;
use Chumper\Zipper\Zipper;
use Exception;
use Illuminate\Http\Request;
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
     * @param Request $request
     *
     * @return Skin
     * @throws Exception
     */
    public function create(Request $request): Skin
    {
        $skin = new Skin();
        $skin->fill($request->only($skin->getFillable()));
        $skin->identifier = Str::slug($skin->name);
        $this->handleZipFile($request->file('file'), $skin->identifier);
        $skin->save();

        return $skin->refresh();
    }

    /**
     * @param Skin $skin
     * @param Request $request
     *
     * @return Skin
     * @throws Exception
     */
    public function update(Skin $skin, Request $request): Skin
    {
        $skin->fill($request->only($skin->getFillable()))->save();

        if ($request->hasFile('file')) {
            $this->handleZipFile($request->file('file'), $skin->identifier);
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
