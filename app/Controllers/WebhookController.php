<?php

namespace App\Controllers;

use Bow\Http\Request;
use App\Controllers\Controller;
use Bow\CQRS\Command\CommandBus;
use App\Services\CinetpayService;
use App\Commands\DispatchDepositWebhookCommand;

class WebhookController extends Controller
{
    /**
     * WebhookController constructor
     *
     * @param CinetpayService $cinetpay_service
     * @param CommandBus $commandBus
     */
    public function __construct(
        private CinetpayService $cinetpay_service,
        private CommandBus $commandBus
    ) {
    }

    /**
     * Process the deposit webhook
     *
     * @param Request $request
     * @return mixed
     */
    public function processDepositWebhook(
        Request $request
    ) {
        $attributes = $request->all();

        $this->cinetpay_service->checkHmacToken(
            (string) $request->getHeader("X-Token"),
            $attributes
        );

        $result = $this->commandBus->execute(
            new DispatchDepositWebhookCommand(
                $attributes["cpm_trans_id"],
                $attributes["cpm_error_message"],
                $attributes["cpm_amount"],
                $attributes,
            )
        );

        return $result->unwrap();
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
        $x_token = $request->getHeader("X-Token");
    }
}
