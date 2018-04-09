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
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\Serializer\JsonApiSerializer;

class JsonApiDataResponse
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var ExtendedTransformerAbstract
     */
    protected $transformer;

    /**
     * @var null|string
     */
    protected $name;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * JsonApiDataResponse constructor.
     * @param mixed $data
     * @param ExtendedTransformerAbstract $transformer
     * @param array $includes
     * @param null|string $name
     */
    public function __construct($data, $transformer, $includes = [], $name = null)
    {
        $this->data = $data;
        $this->name = $name;
        $this->transformer = $transformer;
        $this->manager = (new Manager())->setSerializer(new JsonApiSerializer());
        if ($includes) {
            $this->includes($includes);
        }
    }

    /**
     * @param array $includes
     */
    public function includes($includes)
    {
        $this->manager->parseIncludes($includes);
    }

    /**
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 200, array $headers = array())
    {
        return response()->json($this->manager->createData($this->createResource())->toArray(), $status, $headers);
    }

    /**
     * @return ResourceAbstract
     */
    private function createResource()
    {
        if (is_null($this->data)) {
            return new NullResource($this->data, $this->transformer, $this->getName());
        } else if ($this->data instanceof Model) {
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

    /**
     * @return string
     */
    protected function getName()
    {
        return $this->name ?: $this->transformer->getName();
    }
}
