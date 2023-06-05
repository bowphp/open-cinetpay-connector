<?php

namespace App\Validations;

use Bow\Validation\RequestValidation;

class TransferTransctionValidationRequest extends RequestValidation
{
    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [
            "transaction" => "required",
            "amount" => "required",
            "method" => "required",
            "phone_prefix" => "required|numeric",
            "phone_number" => "required|numeric",
        ];
    }

    /**
     * The custom message
     *
     * @return array
     */
    public function messages()
    {
        return [
            "transaction" => [
                "required" => "The transaction is require"
            ],
            "amount" => [
                "required" => "The amount is require"
            ],
            "currency" => [
                "required" => "The currency is require"
            ],
            "method" => [
                "required" => "The method is require"
            ],
        ];
    }
}
