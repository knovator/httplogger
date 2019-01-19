<?php

namespace Knovators\HttpLogger;

use Illuminate\Http\Request;

/**
 * Interface LogWriter
 * @package knovators\logger\src
 */
interface LogWriter
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function logRequest(Request $request);
}
