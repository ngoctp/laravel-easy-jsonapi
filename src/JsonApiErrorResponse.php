<?php
/**
 * Created by PhpStorm.
 * User: ngoctp
 * Date: 10/6/17
 * Time: 12:04
 */

namespace NgocTP\EasyJsonApi;

class JsonApiErrorResponse
{
    /**
     * @var string
     */
    protected $message;

    /**
     * JsonApiErrorResponse constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 400, array $headers = array())
    {
        $result = [
            'error' => [
                'message' => $this->message,
            ]
        ];

        return response()->json($result, $status, $headers);
    }

}