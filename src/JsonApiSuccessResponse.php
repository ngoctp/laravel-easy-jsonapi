<?php
/**
 * Created by PhpStorm.
 * User: ngoctp
 * Date: 10/6/17
 * Time: 12:04
 */

namespace NgocTP\EasyJsonApi;

class JsonApiSuccessResponse
{
    /**
     * @var string
     */
    protected $message;

    /**
     * JsonApiSuccessResponse constructor.
     * @param null|string $message
     */
    public function __construct($message = null)
    {
        $this->message = $message;
    }

    /**
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 200, array $headers = array())
    {
        $result = [];
        if ($this->message) {
            $result['message'] = $this->message;
        }

        return response()->json($result, $status, $headers);
    }

}