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
use App\CommandHandlers\DispatchDepositWebhookCommandHandler;
use App\CommandHandlers\DispatchTransferWebhookCommandHandler;

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
            DispatchDepositWebhookCommand::class => DispatchDepositWebhookCommandHandler::class,
            DispatchTransferWebhookCommand::class => DispatchTransferWebhookCommandHandler::class,
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
