<?php

namespace knovator\logger\src;

use Illuminate\Http\Request;

/**
 * Interface LogProfile
 * @package knovator\logger\src
 */
interface LogProfile
{
    /**
     * @param Request $request
     * @return bool
     */
    public function shouldLogRequest(Request $request): bool;
}
