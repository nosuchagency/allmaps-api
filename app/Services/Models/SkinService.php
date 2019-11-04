<?php

namespace App\Services\Models;

use App\Contracts\ModelServiceContract;
use App\Models\Skin;
use Chumper\Zipper\Zipper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkinService implements ModelServiceContract
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
     * @return Skin|mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $skin = new Skin();
        $skin->fill($request->only($skin->getFillable()));
        $skin->identifier = Str::slug($skin->name);
        $this->handleZipFile($request->file('file'), $skin->identifier);
        $skin->save();

        return $skin->refresh();
    }

    /**
     * @param Model $skin
     * @param Request $request
     *
     * @return Model|mixed
     * @throws \Exception
     */
    public function update(Model $skin, Request $request)
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
     * @throws \Exception
     */
    private function handleZipFile($file, $directory)
    {
        $path = public_path(config('all-maps.skins.directory') . $directory);
        $this->zipper->make($file)->extractTo($path, []);
    }
}
