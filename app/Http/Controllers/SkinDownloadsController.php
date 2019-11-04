<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use Chumper\Zipper\Zipper;
use Exception;

class SkinDownloadsController extends Controller
{

    /**
     * @var Zipper
     */
    protected $zipper;

    /**
     * ZipController constructor.
     *
     * @param Zipper $zipper
     */
    public function __construct(Zipper $zipper)
    {
        $this->zipper = $zipper;
    }

    /**
     * @param Skin $skin
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function download(Skin $skin)
    {
        if (!$skin->indexFileExists()) {
            abort(404);
        }

        $files = glob($skin->getBasePath());

        $path = storage_path(config('all-maps.skins.download_directory') . $skin->identifier . '.zip');

        try {
            $this->zipper->make($path)->add($files)->close();
        } catch (Exception $exception) {
            abort(500);
        }

        return response()->download($path);
    }
}
