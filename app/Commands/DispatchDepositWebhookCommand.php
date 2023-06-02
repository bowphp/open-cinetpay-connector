<?php

namespace App\Commands;

use Bow\CQRS\Command\CommandInterface;

class DispatchDepositWebhookCommand implements CommandInterface
{
    public function __construct(
        public string $transaction,
        public string $status,
        public string $amount,
        public array $provider_data,
    ) {
    }
}
