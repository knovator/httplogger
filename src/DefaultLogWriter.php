<?php

namespace knovator\logger\src;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use knovator\logger\src\LogWriter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class DefaultLogWriter
 * @package knovator\logger
 */
class DefaultLogWriter implements LogWriter
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function logRequest(Request $request)
    {
        $method = strtoupper($request->getMethod());

        $uri = $request->getPathInfo();

        $bodyAsJson = json_encode($request->except(config('http-logger.except')));

        $files = array_map(function (UploadedFile $file) {
            return $file->getClientOriginalName();
        }, iterator_to_array($request->files));

        $message = "{$method} {$uri} - Body: {$bodyAsJson} - Files: ".implode(', ', $files);

        Log::info($message);
    }
}
