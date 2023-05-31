<?php

use App\Controllers\StatusController;
use App\Controllers\WebhookController;
use App\Controllers\TransactionController;

$app->get('status', StatusController::class)->name('app.status');

$app->post("execute-deposit-transaction", [
    TransactionController::class, "executeDepositTransaction"
])->middleware(["verify-token"]);

$app->post("execute-transfer-transaction", [
    TransactionController::class, "executeTransferTransaction"
])->middleware(["verify-token"]);

$app->post("webhook/deposits", [
    WebhookController::class => "processDepositWebhook"
])->name("deposit.webhook");

$app->post("webhook/transfers", [
    WebhookController::class => "processTransferWebhook"
])->name("transfer.webhook");

$app->post("redirects/:session", [
    StatusController::class => "processSession"
])->name("app.redirect");
