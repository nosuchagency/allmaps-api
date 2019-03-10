<?php

namespace App\Plugins;

use App\Plugins\Assets\FieldCollection;
use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Assets\Field;
use App\Plugins\Search\SearchResults;

class IMS extends BasePlugin
{
    /**
     * @var string
     */
    protected $pluginName = 'IMS';

    /**
     * @return FieldCollection
     */
    public function fields(): FieldCollection
    {
        return new FieldCollection([
            new Field('Identifier 1', 'identifier_1', 'text')
        ]);
    }

    /**
     * @param $payload
     *
     * @return SearchResults
     */
    public function search($payload): SearchResults
    {
        $faust = 1234;

        $id = $this->retrieveFromIMS($faust);

        return $this->getLocations(['identifier_1' => $id]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->pluginName;
    }

    /**
     * @param string $faust
     *
     * @return iterable
     */
    public function retrieveFromIMS(string $faust)
    {
        return [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3]
        ];
    }
}