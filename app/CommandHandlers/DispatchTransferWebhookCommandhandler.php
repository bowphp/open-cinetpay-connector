<?php

namespace App\CommandHandlers;

use Prewk\Result;
use Prewk\Result\Ok;
use Prewk\Result\Err;
use Bow\Http\Client\HttpClient;
use Bow\CQRS\Command\CommandInterface;
use Bow\Http\Exception\BadRequestException;
use Bow\CQRS\Command\CommandHandlerInterface;

class DispatchTransferWebhookCommandhandler implements CommandHandlerInterface
{
    public function __construct(
        public HttpClient $http_client
    ) {
        $this->http_client->addHeaders([
            "X-Api-Key" => app_env("NOTIFICATION_APP_API_KEY"),
            "User-Agent" => app_env("APP_NAME"),
        ]);
    }

    /**
     * Handler the command
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function process(CommandInterface $command): Result
    {
        $response = $this->http_client->acceptJson()->post(app_env("NOTIFICATION_APP_DEPOSIT_URL"), [
            "transaction" => $command->transaction,
            "amount" => $command->amount,
            "status" => $command->status == "SUCCES" ? "completed" : "failed",
            "provider" => [
                "name" => "cinetpay",
                "data" => $command->provider_data
            ]
        ]);

        if ($response->statusCode() !== 200) {
            $error = $response->toJson();
            return new Err(
                new BadRequestException(
                    "Cannot contact the notification api webhook: " . $error->message,
                )
            );
        }

        return new Ok($command->provider_data);
    }
}
