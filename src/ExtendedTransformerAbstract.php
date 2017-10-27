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

    /**
     * @param mixed $resource
     * @return array
     */
    public abstract function transform($resource);
}