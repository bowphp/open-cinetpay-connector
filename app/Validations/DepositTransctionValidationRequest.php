<?php

namespace App\Validations;

use Bow\Validation\RequestValidation;

class DepositTransctionValidationRequest extends RequestValidation
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
            "currency" => "required",
            "phone_number" => "required|numeric",
            "phone_prefix" => "required|numeric",
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
            "phone_prefix" => [
                "required" => "The phone_prefix is require",
                "numeric" => "The phone_prefix should be a numeric",
            ],
            "phone_number" => [
                "required" => "The phone_number is require",
                "numeric" => "The phone_number should be a numeric",
            ],
        ];
    }
}
