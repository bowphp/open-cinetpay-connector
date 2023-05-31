<?php

namespace App\Commands;

use Prewk\Result;
use Prewk\Result\Ok;
use Prewk\Result\Err;
use Bow\Http\Client\HttpClient;
use Bow\CQRS\Command\CommandInterface;
use Bow\Http\Exception\BadRequestException;
use Bow\CQRS\Command\CommandHandlerInterface;

class DispatchDepositWebhookCommandhandler implements CommandHandlerInterface
{
    public function __construct(
        public HttpClient $http_client
    ) {
        $this->http_client->addHeaders([
            "X-Api-Key" => app_env("DJEKANOO_API_KEY")
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
        $response = $this->http_client->acceptJson()->post(app_env("DJEKANOO_API_URL"), [
            "transaction" => $command->transaction,
            "amount" => $command->amount,
            "status" => $command->status,
            "provider" => [
                "name" => "cinetpay",
                "data" => $command->provider_data
            ]
        ]);

        if ($response->statusCode() !== 200) {
            return new Err(
                new BadRequestException(
                    "Cannot contact the djekanoo api webhook"
                )
            );
        }

        return new Ok($command->provider_data);
    }
}
