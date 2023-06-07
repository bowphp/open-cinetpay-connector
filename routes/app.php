<?php

use App\Controllers\StatusController;
use App\Controllers\WebhookController;
use App\Controllers\TransactionController;

$app->get('status', StatusController::class)->name('app.status');

$app->middleware(["verify-api-key"])->post("generate-deposit-session", [
    TransactionController::class, "executeDepositTransaction"
]);

$app->middleware(["verify-api-key"])->post("execute-transfer-transaction", [
    TransactionController::class, "executeTransferTransaction"
]);

$app->post("webhook/deposits/:session", [WebhookController::class, "processDepositWebhook"])->name("deposit.webhook");
$app->post("webhook/transfers/:session", [WebhookController::class, "processTransferWebhook"])->name("transfer.webhook");

$app->post("redirects/:session", [StatusController::class, "processSession"])->name("app.redirect");
