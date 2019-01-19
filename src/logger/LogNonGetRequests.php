<?php

namespace logger;

use Illuminate\Http\Request;

/**
 * Class LogNonGetRequests
 * @package knovators\logger\src
 */
class LogNonGetRequests implements LogProfile
{
    /**
     * @param Request $request
     * @return bool
     */
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['post', 'put', 'patch', 'delete']);
    }
}
