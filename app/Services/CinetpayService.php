<?php

namespace App\Services;

use Bow\Http\Exception\BadRequestException;

class CinetpayService
{
    /**
     * Generate the Hmac Token
     *
     * @param string $token
     * @param array $attributes
     * @return bool
     */
    public function checkHmacToken(string $token, array $attributes): bool
    {
        return hash_equals($this->generateHmacToken($attributes), $token) ?:
            throw new BadRequestException(
                "The x-token is invalid"
            );
    }

    /**
     * Generate the hmac token
     *
     * @param array $attributes
     * @return string
     */
    public function generateHmacToken(array $attributes): string
    {
        $cpm_site_id = $attributes["cpm_site_id"];
        $cpm_trans_id = $attributes["cpm_trans_id"];
        $cpm_trans_date = $attributes["cpm_trans_date"];
        $cpm_amount = $attributes["cpm_amount"];
        $cpm_currency = $attributes["cpm_currency"];
        $signature = $attributes["signature"];
        $payment_method = $attributes["payment_method"];
        $cel_phone_num = $attributes["cel_phone_num"];
        $cpm_phone_prefixe = $attributes["cpm_phone_prefixe"];
        $cpm_language = $attributes["cpm_language"];
        $cpm_version = $attributes["cpm_version"];
        $cpm_payment_config = $attributes["cpm_payment_config"];
        $cpm_page_action = $attributes["cpm_page_action"];
        $cpm_custom = $attributes["cpm_custom"];
        $cpm_designation = $attributes["cpm_designation"];
        $cpm_error_message = $attributes["cpm_error_message"];

        $data = $cpm_site_id . $cpm_trans_id . $cpm_trans_date . $cpm_amount .
            $cpm_currency . $signature . $payment_method . $cel_phone_num . $cpm_phone_prefixe .
            $cpm_language . $cpm_version . $cpm_payment_config . $cpm_page_action . $cpm_custom .
            $cpm_designation . $cpm_error_message;

        return hash_hmac('sha256', $data, app_env("CINETPAY_SECRET"));
    }
}
