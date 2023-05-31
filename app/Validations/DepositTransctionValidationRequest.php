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
            "msisdn" => "required",
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
            "msisdn" => [
                "required" => "The msisdn is require"
            ],
        ];
    }
}
