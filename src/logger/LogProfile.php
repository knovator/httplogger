<?php

namespace logger;

use Illuminate\Http\Request;

/**
 * Interface LogProfile
 * @package knovators\logger\src
 */
interface LogProfile
{
    /**
     * @param Request $request
     * @return bool
     */
    public function shouldLogRequest(Request $request): bool;
}
