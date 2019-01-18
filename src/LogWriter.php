<?php

namespace knovator\logger\src;

use Illuminate\Http\Request;

/**
 * Interface LogWriter
 * @package knovator\logger\src
 */
interface LogWriter
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function logRequest(Request $request);
}
