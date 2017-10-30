<?php
/**
 * Created by PhpStorm.
 * User: ngoctp
 * Date: 10/6/17
 * Time: 12:04
 */

namespace NgocTP\EasyJsonApi;

use Illuminate\Validation\Validator;

class JsonApiFormErrorResponse
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var null|string
     */
    protected $message;

    /**
     * JsonApiFormErrorResponse constructor.
     * @param Validator $validator
     * @param null|string $message
     */
    public function __construct(Validator $validator, $message = null)
    {
        $this->validator = $validator;
        $this->message = $message;
    }

    /**
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response($status = 400, array $headers = array())
    {
        $errorFields = [];
        foreach ($this->validator->getMessageBag()->getMessages() as $field => $messages) {
            $errorFields[$field] = $messages[0];
        }

        $result = [
            'error' => [
                'fields' => $errorFields,
            ]
        ];

        if ($this->message) {
            $result['error']['message'] = $this->message;
        }

        return response()->json($result, $status, $headers);
    }

}