<?php

namespace App\Commands;

use Bow\CQRS\Command\CommandInterface;

class ExecuteDepositCommand implements CommandInterface
{
    /**
     * ExecuteDepositCommand constructor
     *
     * @param string $transaction
     * @param float $amount
     * @param string $currency
     * @param string $phone
     */
    public function __construct(
        public string $transaction,
        public float $amount,
        public string $currency,
        public object $phone,
    ) {
    }
}
