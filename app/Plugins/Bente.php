<?php

namespace App\Plugins;

use App\Plugins\Assets\Field;
use App\Plugins\Assets\FieldCollection;
use App\Plugins\Contracts\BasePlugin;
use App\Plugins\Search\SearchResults;
use Illuminate\Database\Eloquent\Builder;

class Bente extends BasePlugin
{
    /**
     * @var string
     */
    protected $pluginName = 'Bentes Plugin';

    /**
     * @return FieldCollection
     */
    public function fields(): FieldCollection
    {
        return new FieldCollection([
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
        return $this->getLocations([], $builder);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->pluginName;
    }
}