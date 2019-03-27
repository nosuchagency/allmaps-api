<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HasImage
{
    /**
     * @param  $image
     * @param  $removeExistingImage
     *
     * @return void
     */
    public function setImage($image, $removeExistingImage = true)
    {
        if (empty($image)) {
            $this->removeExistingImage();
            return;
        }

        try {
            $img = Image::make($image);
        } catch (\Exception $e) {
            return;
        }

        if (!Storage::disk('public')->exists(self::IMAGE_DIRECTORY_PATH)) {
            Storage::disk('public')->makeDirectory(self::IMAGE_DIRECTORY_PATH);
        }

        $storagePath = Storage::disk('public')->path(self::IMAGE_DIRECTORY_PATH);

        $mime = explode('/', $img->mime())[1];
        $imageName = time() . uniqid() . '.' . $mime;
        $img->save($storagePath . '/' . $imageName);

        if ($this->image && $removeExistingImage) {
            $this->removeExistingImage();
        }

        $this->image = self::IMAGE_DIRECTORY_PATH . '/' . $imageName;
    }

    /**
     * Remove existing image from disk
     *
     * @return void
     */
    private function removeExistingImage()
    {
        if (Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }

        $this->image = null;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image ? url('/storage' . $this->image) : null;
    }
}