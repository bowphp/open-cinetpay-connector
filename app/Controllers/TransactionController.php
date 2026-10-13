<?php

namespace App\Controllers;

use Bow\CQRS\Command\CommandBus;
use App\Commands\ExecuteDepositCommand;
use App\Commands\ExecuteTransferCommand;
use App\Validations\DepositTransactionValidationRequest;
use App\Validations\TransferTransactionValidationRequest;

class TransactionController
{
    /**
     * TransactionController constuctor
     *
     * @param CommandBus $commandBus
     */
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    /**
     * Execute the deposit transaction
     *
     * @param DepositTransactionValidationRequest $request
     * @return mixed
     */
    public function executeDepositTransaction(
        DepositTransactionValidationRequest $request
    ): mixed {
        $phone = [
            "prefix" => $request->get("phone_prefix"),
            "number" => $request->get("phone_number"),
        ];

        $result = $this->commandBus->execute(
            new ExecuteDepositCommand(
                $request->get("transaction"),
                $request->get("amount"),
                $request->get("currency"),
                (object) $phone,
            )
        );

        return $result->unwrap();
    }

    /**
     * Execute the transfer transaction
     *
     * @param TransferTransactionValidationRequest $request
     * @return mixed
     */
    public function executeTransferTransaction(
        TransferTransactionValidationRequest $request
    ): mixed {
        $phone = [
            "prefix" => $request->get("phone_prefix"),
            "number" => $request->get("phone_number"),
        ];

        $result = $this->commandBus->execute(
            new ExecuteTransferCommand(
                $request->get("transaction"),
                $request->get("amount"),
                $request->get("method"),
                (object) $phone,
            )
        );

        return $result->unwrap();
    }
}
