<?php

namespace App\Plugins\Assets;

class Field
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $type;

    /**
     * PluginField constructor.
     *
     * @param string $label
     * @param string $key
     * @param string $type
     */
    public function __construct(string $label, string $key, string $type)
    {
        $this->label = $label;
        $this->key = $key;
        $this->type = $type;
    }

    /**
     * @param $property
     *
     * @return mixed|null
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }
}