<?php

namespace App\Commands;

use Prewk\Result\Ok;
use Prewk\Result\Err;
use Bow\Http\Client\HttpClient;
use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Command\CommandHandlerInterface;
use Bow\Http\Exception\InternalServerErrorException;

class ExecuteDepositCommandHandler implements CommandHandlerInterface
{
    /**
     * ExecuteDepositCommandHandler constructor
     *
     * @param HttpClient $http_client
     */
    public function __construct(
        public HttpClient $http_client,
    ) {
    }

    /**
     * Process the command
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function process(CommandInterface $command): mixed
    {
        $payload = [
            "apikey" => app_env("CINETPAY_API_KEY"),
            "site_id" => app_env("CINETPAY_SITE_ID"),
            "secret_key" => app_env("CINETPAY_API_SECRET"),
            "transaction_id" => $command->transaction,
            "amount" => $command->amount,
            "currency" => $command->currency,
            "description" => "{$command->amount}{$command->currency} for garba",
            "notify_url" => route("app.webhook.status", true),
            "return_url" => route("app.webhook.redirect", true),
            "channels" => "MOBILE_MONEY",
            "lang" => $command->lang ?? "fr",
            "lock_phone_number" => true,
            "customer_id" => $command->transaction,
            "customer_name" => $command->transaction,
            "customer_surname" => $command->transaction,
            "customer_phone_number" => $command->msisdn
        ];

        // Run the request
        $response = $this->http_client->acceptJson()->post(app_env('CINETPAY_PAYMENT_URL'), $payload);

        if ($response->statusCode() !== 200) {
            $error = $response->toArray();
            return new Err(
                new InternalServerErrorException(
                    $error["description"]
                )
            );
        }

        return new Ok($response->toJson());
    }
}
