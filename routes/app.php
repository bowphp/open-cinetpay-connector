<?php

use App\Controllers\StatusController;
use App\Controllers\TransactionController;

$app->get('status', StatusController::class)->name('app.status');

$app->post("execute-deposit-transaction", [
    TransactionController::class, "executeDepositTransaction"
])->middleware(["verify-token"]);

$app->post("webhook/deposits", [
    WebhookController::class => "processDepositWebhook"
])->name("app.webhook.status");

$app->post("redirects/deposits", [
    WebhookController::class => "processDepositWebhook"
])->name("app.webhook.redirect");
