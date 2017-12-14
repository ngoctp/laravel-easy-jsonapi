<?php
/**
 * Created by PhpStorm.
 * User: ngoctp
 * Date: 10/6/17
 * Time: 12:05
 */

namespace NgocTP\EasyJsonApi;


use League\Fractal\TransformerAbstract;

abstract class ExtendedTransformerAbstract extends TransformerAbstract
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options;

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue($key)
    {
        return array_get($this->options, $key, null);
    }

    public function getOptions($key)
    {
        return array_get($this->options, $key, []);
    }

    /**
     * @param mixed $data
     * @param callable|ExtendedTransformerAbstract $transformer
     * @param null $resourceKey
     * @return \League\Fractal\Resource\Item
     */
    public function item($data, $transformer, $resourceKey = null)
    {
        return parent::item($data, $transformer, is_null($resourceKey) ? $transformer->getName() : $resourceKey);
    }

    /**
     * @param mixed $data
     * @param callable|ExtendedTransformerAbstract $transformer
     * @param null $resourceKey
     * @return \League\Fractal\Resource\Collection
     */
    public function collection($data, $transformer, $resourceKey = null)
    {
        return parent::collection($data, $transformer, is_null($resourceKey) ? $transformer->getName() : $resourceKey);
    }

    /**
     * @return \League\Fractal\Resource\NullResource
     */
    public function null()
    {
        return parent::null();
    }

    /**
     * @param mixed $resource
     * @return array
     */
    public abstract function transform($resource);
}
