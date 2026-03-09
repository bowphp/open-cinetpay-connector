<?php

namespace App\Controllers;

use Bow\Http\Request;

class StatusController
{
    /**
     * Show status
     *
     * @param Request $request
     * @return string|null
     */
    public function __invoke(Request $request): ?string
    {
        return response()->json([
            "message" => "Server is working"
        ]);
    }

    /**
     * Process session redirect
     *
     * @param Request $request
     * @return string|null
     */
    public function processSession(Request $request): ?string
    {
        $session = $request->get("session");

        return response()->json([
            "message" => "Session processed",
            "session" => $session
        ]);
    }
}
