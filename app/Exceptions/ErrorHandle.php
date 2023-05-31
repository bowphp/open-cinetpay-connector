<?php

namespace App\Exceptions;

use Exception;
use PDOException;
use App\Events\ActivityEvent;
use Bow\Http\Exception\HttpException;
use Bow\Application\Exception\BaseErrorHandler;
use Bow\Validation\Exception\ValidationException;

class ErrorHandle extends BaseErrorHandler
{
    /**
     * handle the error
     *
     * @param Exception $exception
     * @return void
     */
    public function handle($exception)
    {
        $code = "INTERNAL_SERVER_ERROR";

        if ($exception instanceof HttpException) {
            $code = $exception->getStatus();
        }

        return $this->json($exception, $code);
    }

    /**
     * Send the json as response
     *
     * @param string $data
     * @param mixed $code
     * @return mixed
     */
    private function json($exception, $code = null)
    {
        if (is_null($code)) {
            if (method_exists($exception, 'getStatus')) {
                $code = $exception->getStatus();
            } else {
                $code = 'INTERNAL_SERVER_ERROR';
            }
        }

        if (app_env("APP_ENV") == "production" && $exception instanceof PDOException) {
            $message = 'Une erreur interne est survenu';
        } else {
            $message = $exception->getMessage();
        }

        $response = [
            'message' => $message,
            'code' => $code,
            'time' => date('Y-m-d H:i:s')
        ];

        $status = 500;

        if ($exception instanceof HttpException) {
            $status = $exception->getStatusCode();
            $response = array_merge($response, compact('status'));
            if ($exception instanceof ValidationException) {
                $response["errors"] = $exception->getErrors();
            }
        }

        if (app_env("APP_ENV") != "production") {
            $response["trace"] = $exception->getTrace();
        }

        die(json($response, $status));
    }
}
