<?php

namespace App\Commands;

use Prewk\Result\Ok;
use Prewk\Result\Err;
use Bow\Http\Client\HttpClient;
use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Command\CommandHandlerInterface;
use Bow\Http\Exception\BadRequestException;
use Bow\Http\Exception\InternalServerErrorException;

class ExecuteTransferCommandHandler implements CommandHandlerInterface
{
    /**
     * ExecuteTransferCommandHandler constructor
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
        $token = $this->generateToken();

        $this->createCustomer($command, $token);

        $payload = [
            "prefix" => $command->phone->prefix,
            "phone" => $command->phone->number,
            "amount" => (int) $command->amount,
            "notify_url" => route("transfer.webhook", true),
            "client_transaction_id" => $command->transaction,
            "payment_method" => $command->method,
        ];

        // Run the request
        $response = $this->http_client
            ->addHeaders(["Content-Type" => "application/x-www-form-urlencoded"])
            ->post($this->formatUrl(app_env('CINETPAY_TRANSFER_URL'), $token), [
                "data" => json_encode([$payload])
            ]);

        if ($response->statusCode() !== 200) {
            $error = $response->toArray();
            if (isset($error["message"]) && $error["message"] == "INSUFFICIENT_BALANCE") {
                // send telegram message
            }

            return new Err(
                new BadRequestException(
                    $error["error"] ?? $error["description"]
                )
            );
        }

        $content = $response->toJson();
        $content->status = "pending";

        cache("transfers:" . $command->transaction, array_merge($payload, (array) $content));

        return new Ok($content);
    }

    /**
     * Generate the token
     *
     * @return string
     */
    private function generateToken()
    {
        $token = cache("token");

        if (!is_null($token)) {
            return $token;
        }

        // Run the request
        $response = $this->http_client->post(app_env("CINETPAY_TRANSFER_TOKEN"), [
            "apikey" => app_env("CINETPAY_KEY"),
            "password" => app_env("CINETPAY_TRANSFER_PASSWORD"),
        ]);

        if ($response->statusCode() !== 200) {
            $error = $response->toArray();
            throw new BadRequestException(
                $error["description"]
            );
        }

        $content = $response->toJson();

        cache("token", $content->data->token, 60);

        return $content->data->token;
    }

    /**
     * Format the url
     *
     * @param string $url
     * @param string $token
     * @return string
     */
    private function formatUrl(string $url, string $token): string
    {
        return $url . "?" . http_build_query(["lang" => "fr", "token" => $token]);
    }

    /**
     * Create the customer transfer
     *
     * @param ExecuteTransferCommand $command
     * @param string $token
     * @return void
     */
    private function createCustomer(ExecuteTransferCommand $command, string $token)
    {
        $content = [
            "prefix" => $command->phone->prefix,
            "phone" => $command->phone->number,
            "name" => "Code",
            "surname" => "Codeur",
            "email" => "app@gmail.com",
        ];

        $response = $this->http_client
            ->addHeaders(["Content-Type" => "application/x-www-form-urlencoded"])
            ->post($this->formatUrl(app_env('CINETPAY_CONTACT_URL'), $token), [
                "data" => json_encode([$content])
            ]);

        if ($response->statusCode() !== 200) {
            throw new BadRequestException(
                "Cannt create the customer on cinetpay"
            );
        }

        return true;
    }
}
