<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PluginExists implements Rule
{
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
        $filepath = config('all-maps.plugins.directory') . $value . '.php';

        if (file_exists($filepath)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The specified plugin does not exist';
    }
}
