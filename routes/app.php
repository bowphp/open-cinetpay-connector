<?php

use App\Controllers\StatusController;
use App\Controllers\WebhookController;
use App\Controllers\TransactionController;

$router->get('status', StatusController::class)->name('app.status');

$router->middleware(["verify-api-key"])->post("generate-deposit-session", [
    TransactionController::class, "executeDepositTransaction"
]);

$router->middleware(["verify-api-key"])->post("execute-transfer-transaction", [
    TransactionController::class, "executeTransferTransaction"
]);

$router->post("webhook/deposits/:session", [WebhookController::class, "processDepositWebhook"])->name("deposit.webhook");
$router->post("webhook/transfers/:session", [WebhookController::class, "processTransferWebhook"])->name("transfer.webhook");

$router->post("redirects/:session", [StatusController::class, "processSession"])->name("app.redirect");
