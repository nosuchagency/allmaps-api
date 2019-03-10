<?php

namespace App\Plugins;

use App\Plugins\Assets\FieldCollection;
use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Assets\Field;
use App\Plugins\Search\SearchResults;

class Niels extends BasePlugin
{
    /**
     * @var string
     */
    protected $pluginName = 'Niels';

    /**
     * @return FieldCollection
     */
    public function fields(): FieldCollection
    {
        return new FieldCollection([
            new Field('ID', 'id', 'text'),
        ]);
    }

    /**
    * @param $payload
    *
    * @return SearchResults
    */
    public function search($payload): SearchResults
    {
        return $this->getLocations(['id' => '1']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->pluginName;
    }
}