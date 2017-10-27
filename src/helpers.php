<?php

if (! function_exists('jsonapi')) {
    /**
     * @param \Illuminate\Database\Eloquent\Model|array|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator $data
     * @param \NgocTP\EasyJsonApi\ExtendedTransformerAbstract $transformer
     * @param array $includes
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function jsonapi($data, $transformer, $includes = [], $name = null)
    {
        $response = new \NgocTP\EasyJsonApi\JsonApiResponse($data, $transformer, $includes, $name);
        return $response->response();
    }
}
