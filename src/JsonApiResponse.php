<?php
/**
 * Created by PhpStorm.
 * User: ngoctp
 * Date: 10/6/17
 * Time: 12:04
 */

namespace NgocTP\EasyJsonApi;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\JsonApiSerializer;

class JsonApiResponse
{
    protected $data;
    /**
     * @var ExtendedTransformerAbstract
     */
    protected $transformer;

    protected $response;

    protected $name;
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * JsonApiResponse constructor.
     * @param $data
     * @param ExtendedTransformerAbstract $transformer
     * @param array $includes
     * @param string $name
     */
    public function __construct($data, $transformer, $includes = [], $name = null)
    {
        $this->data = $data;
        $this->name = $name;
        $this->transformer = $transformer;
        $this->manager = (new Manager())->setSerializer(new JsonApiSerializer());
        if ($includes) {
            $this->manager->parseIncludes($includes);
        }
        $this->response = response();

    }

    public function includes($includes)
    {
        $this->manager->parseIncludes($includes);
    }

    public function response()
    {
        return response()->json($this->manager->createData($this->createResource())->toArray());
    }

    /**
     * @return ResourceAbstract
     */
    private function createResource()
    {
        if ($this->data instanceof Model) {
            return new Item($this->data, $this->transformer, $this->getName());
        } else if ($this->data instanceof \Illuminate\Support\Collection) {
            return new Collection($this->data, $this->transformer, $this->getName());
        } else if (is_array($this->data)) {
            return new Collection($this->data, $this->transformer, $this->getName());
        } else if ($this->data instanceof LengthAwarePaginator) {
            $collection = new Collection($this->data->getCollection(), $this->transformer, $this->getName());
            $collection->setPaginator(new IlluminatePaginatorAdapter($this->data));
            return $collection;
        }
    }

    protected function getName()
    {
        return $this->name ?: $this->transformer->getName();
    }
}