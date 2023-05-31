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
     * @param string $msisdn
     */
    public function __construct(
        public string $transaction,
        public float $amount,
        public string $currency,
        public string $msisdn,
    ) {
    }
}
