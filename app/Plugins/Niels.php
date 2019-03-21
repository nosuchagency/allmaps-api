<?php

namespace App\Plugins;

use App\Plugins\Assets\FieldCollection;
use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Assets\Field;
use App\Plugins\Search\SearchResults;
use Illuminate\Database\Eloquent\Builder;

class Niels extends BasePlugin
{
    /**
     * @var string
     */
    protected $pluginName = 'Niels Plugin';

    /**
     * @return FieldCollection
     */
    public function fields(): FieldCollection
    {
        return new FieldCollection([
            new Field('ID', 'id', 'text'),
            new Field('Faust', 'faust', 'boolean'),
            new Field('Hest', 'hest', 'text'),
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
        return $this->getLocations(['id' => '1'], $builder);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->pluginName;
    }
}