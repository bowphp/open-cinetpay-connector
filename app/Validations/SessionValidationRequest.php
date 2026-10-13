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
    protected function rules(): array
    {
        return [
            "session" => "required|regex:^([a-z0-9]+\\-){4}[a-z0-9]+$"
        ];
    }

    /**
     * The custom messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "session" => [
                "required" => "The session id is required",
                "regex" => "The session id {session} is malformed"
            ]
        ];
    }
}
