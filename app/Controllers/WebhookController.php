<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Bow\Http\Request;

class WebhookController extends Controller
{
    /**
     * Process the deposit webhook
     *
     * @param Request $request
     * @return mixed
     */
    public function processDepositWebhook(
        Request $request
    ) {
    }

    /**
     * Process the transfer webhook
     *
     * @param Request $request
     * @return mixed
     */
    public function processTransferWebhook(
        Request $request
    ) {
    }
}
