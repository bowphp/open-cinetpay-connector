<?php

namespace App\Controllers;

use Bow\Http\Request;
use App\Controllers\Controller;
use Bow\CQRS\Command\CommandBus;
use App\Commands\ExecuteDepositCommand;
use App\Commands\ExecuteTransferCommand;
use App\Validations\DepositTransctionValidationRequest;
use App\Validations\TransferTransctionValidationRequest;
use Bow\Validation\Exception\ValidationException;
use Bow\Validation\Validator;

class TransactionController extends Controller
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
     * @param DepositTransctionValidationRequest $request
     * @return mixed
     */
    public function executeDepositTransaction(
        DepositTransctionValidationRequest $request
    ) {
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
     * @param TransferTransctionValidationRequest $request
     * @return mixed
     */
    public function executeTransferTransaction(
        TransferTransctionValidationRequest $request
    ) {
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
