<?php

namespace App\Plugins\Assets;

use Illuminate\Support\Collection;

class FieldCollection extends Collection
{
    /**
     * FieldCollection constructor.
     *
     * @param array $items
     */
    public function __construct($items = [])
    {
        parent::__construct($items);
    }
}