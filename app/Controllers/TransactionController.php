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
        $result = $this->commandBus->execute(
            new ExecuteDepositCommand(
                $request->get("transaction"),
                $request->get("amount"),
                $request->get("currency"),
                $request->get("msisdn"),
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
        $validation = Validator::make((array) $request->get("phone"), [
            "prefix" => "required|number",
            "number" => "required|number"
        ], [
            "prefix" => [
                "required" => "The phone.prefix is required",
                "number" => "The phone.prefix {prefix} should be number",
            ],
            "number" => [
                "required" => "The phone.prefix is required",
                "number" => "The phone.prefix {prefix} should be number",
            ],
        ]);

        if ($validation->fails()) {
            $validation->throwError();
        }

        $result = $this->commandBus->execute(
            new ExecuteTransferCommand(
                $request->get("transaction"),
                $request->get("amount"),
                $request->get("method"),
                (object) $request->get("phone"),
            )
        );

        return $result->unwrap();
    }
}
