<?php

namespace App\Plugins;

use App\Plugins\Assets\FieldCollection;
use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Assets\Field;
use App\Plugins\Search\SearchResults;
use Illuminate\Database\Eloquent\Builder;

class IMS extends BasePlugin
{
    /**
     * @var string
     */
    protected $pluginName = 'IMS Plugin';

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
     * @param Builder $builder
     *
     * @return SearchResults
     */
    public function search($payload, Builder $builder): SearchResults
    {
        $faust = 1234;

        $id = $this->retrieveFromIMS($faust);

        return $this->getLocations(['identifier_1' => $id], $builder);
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