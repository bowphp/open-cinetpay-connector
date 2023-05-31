<?php

namespace App\Validations;

use Bow\Validation\RequestValidation;

class SessionValidationRequest extends RequestValidation
{
    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            "session" => "require|regex:^([a-z0-9]+\-){4}[a-z0-9]+$"
        ];
    }

    /**
     * The custom messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            "session" => [
                "require" => "The session id is require",
                "regex" => "The session id {session} is malformed"
            ]
        ];
    }
}
