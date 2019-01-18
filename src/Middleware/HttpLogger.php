<?php

namespace knovator\logger\src\Middleware;

use Closure;
use Illuminate\Http\Request;
use knovator\logger\src\LogProfile;
use knovator\logger\src\LogWriter;


/**
 * Class HttpLogger
 * @package knovator\logger\src\Middleware
 */
class HttpLogger
{
    protected $logProfile;
    protected $logWriter;

    /**
     * HttpLogger constructor.
     * @param LogProfile $logProfile
     * @param LogWriter $logWriter
     */
    public function __construct(LogProfile $logProfile, LogWriter $logWriter)
    {
        $this->logProfile = $logProfile;
        $this->logWriter = $logWriter;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->logProfile->shouldLogRequest($request)) {
            $this->logWriter->logRequest($request);
        }

        return $next($request);
    }
}
