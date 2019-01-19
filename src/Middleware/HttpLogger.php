<?php

namespace Knovators\HttpLogger\Src\Middleware;

use Closure;
use Illuminate\Http\Request;
use logger\LogProfile;
use logger\LogWriter;


/**
 * Class HttpLogger
 * @package Knovators\HttpLogger\Src\Middleware
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
