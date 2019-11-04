<?php

namespace App\Rules;

use Chumper\Zipper\Zipper;
use Illuminate\Contracts\Validation\Rule;
use Exception;
use Illuminate\Support\Str;

class SkinZipFileRule implements Rule
{

    /**
     * @var Zipper
     */
    protected $zipper;

    /**
     * SkinZipFileRule constructor.
     */
    public function __construct()
    {
        $this->zipper = new Zipper();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $result = $this->zipper->make($value)->getFileContent('index.html');
        } catch (Exception $exception) {
            return false;
        }

        return $result ? Str::contains($result, config('all-maps.skins.data_key')) : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The zip file is either missing the index.html or the data key ' . config('all-maps.skins.data_key');
    }
}
