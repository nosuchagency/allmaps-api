<?php

namespace App\Plugins\Assets;

class Field implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $value;

    /**
     * PluginField constructor.
     *
     * @param string $label
     * @param string $identifier
     * @param string $type
     */
    public function __construct(string $label, string $identifier, string $type)
    {
        $this->label = $label;
        $this->identifier = $identifier;
        $this->type = $type;
    }

    /**
     * @param $property
     * @param $value
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
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

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'label' => $this->label,
            'identifier' => $this->identifier,
            'type' => $this->type,
            'value' => $this->value,
        ];
    }
}