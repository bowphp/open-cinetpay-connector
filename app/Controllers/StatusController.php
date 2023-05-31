<?php

namespace App\Controllers;

use Bow\Http\Request;
use App\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Show status
     *
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request): ?string
    {
        return $this->response()->json([
            "message" => "Server is working"
        ]);
    }
}
