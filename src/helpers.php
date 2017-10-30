<?php

if (! function_exists('eja_data')) {
    /**
     * @param \Illuminate\Database\Eloquent\Model|array|\Illuminate\Support\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator $data
     * @param \NgocTP\EasyJsonApi\ExtendedTransformerAbstract $transformer
     * @param array $includes
     * @param null|string $name
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_data($data, $transformer, $includes = [], $name = null, $status = 200, array $headers = array())
    {
        $response = new \NgocTP\EasyJsonApi\JsonApiDataResponse($data, $transformer, $includes, $name);
        return $response->response($status, $headers);
    }
}

if (! function_exists('eja_form_error')) {
    /**
     * @param \Illuminate\Validation\Validator $validator
     * @param null|string $message
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_form_error(\Illuminate\Validation\Validator $validator, $message = null, $status = 400, array $headers = array())
    {
        $response = new \NgocTP\EasyJsonApi\JsonApiFormErrorResponse($validator, $message);
        return $response->response($status, $headers);
    }
}

if (! function_exists('eja_error')) {
    /**
     * @param string $message
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_error($message, $status = 400, array $headers = array())
    {
        $response = new \NgocTP\EasyJsonApi\JsonApiErrorResponse($message);
        return $response->response($status, $headers);
    }
}

if (! function_exists('eja_success')) {
    /**
     * @param null|string $message
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    function eja_success($message = null, $status = 200, array $headers = array())
    {
        $response = new \NgocTP\EasyJsonApi\JsonApiSuccessResponse($message);
        return $response->response($status, $headers);
    }
}
