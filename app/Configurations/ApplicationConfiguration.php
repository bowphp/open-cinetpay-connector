<?php

namespace App\Configurations;

use Bow\CQRS\Registration;
use Bow\Configuration\Loader;
use Bow\Configuration\Configuration;
use App\Commands\ExecuteDepositCommand;
use App\Commands\ExecuteTransferCommand;
use App\Commands\DispatchDepositWebhookCommand;
use App\Commands\DispatchTransferWebhookCommand;
use App\CommandHandlers\ExecuteDepositCommandHandler;
use App\CommandHandlers\ExecuteTransferCommandHandler;
use App\CommandHandlers\DispatchDepositWebhookCommandhandler;
use App\CommandHandlers\DispatchTransferWebhookCommandhandler;

class ApplicationConfiguration extends Configuration
{
    /**
     * Launch configuration
     *
     * @param Loader $config
     * @return void
     */
    public function create(Loader $config): void
    {
        Registration::commands([
            ExecuteDepositCommand::class => ExecuteDepositCommandHandler::class,
            ExecuteTransferCommand::class => ExecuteTransferCommandHandler::class,
            DispatchDepositWebhookCommand::class => DispatchDepositWebhookCommandhandler::class,
            DispatchTransferWebhookCommand::class => DispatchTransferWebhookCommandhandler::class,
        ]);
    }

    /**
     * Start the configured package
     *
     * @return void
     */
    public function run(): void
    {
        //
    }
}
