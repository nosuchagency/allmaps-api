<?php

namespace App\Plugins\Contracts;

use App\Plugins\Assets\FieldCollection;

interface Plugin
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return FieldCollection
     */
    public function fields(): FieldCollection;
}