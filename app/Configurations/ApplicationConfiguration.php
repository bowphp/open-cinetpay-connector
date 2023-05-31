<?php

namespace App\Configurations;

use Bow\CQRS\Registration;
use Bow\Configuration\Loader;
use Bow\Configuration\Configuration;
use App\Commands\ExecuteDepositCommand;
use App\Commands\ExecuteDepositCommandHandler;

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
            ExecuteDepositCommand::class => ExecuteDepositCommandHandler::class
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
