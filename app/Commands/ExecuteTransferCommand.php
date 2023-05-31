<?php

namespace App\Commands;

use Bow\CQRS\Command\CommandInterface;

class ExecuteTransferCommand implements CommandInterface
{
    /**
     * ExecuteTransferCommand constructor
     *
     * @param string $transaction
     * @param float $amount
     * @param string $method
     * @param object $phone
     */
    public function __construct(
        public string $transaction,
        public float $amount,
        public string $method,
        public object $phone
    ) {
    }
}
