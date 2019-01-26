<?php

namespace Knovators\HttpLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class DefaultLogWriter
 * @package knovators\logger
 */
class DefaultLogWriter implements LogWriter
{
    /**
     * @param Request $request
     * @return mixed|void
     */
    public function logRequest(Request $request) {
        $method = strtoupper($request->getMethod());

        $uri = $request->getPathInfo();


        $bodyAsJson = json_encode($request->except(config('http-logger.except')));

        $files = array_map(function (UploadedFile $file) {
            return $file->getClientOriginalName();
        }, iterator_to_array($request->files));

        $message = "{$method} {$uri} - Body: {$bodyAsJson}";
        if (!empty(implode(', ', $files))) {
            $message .= " - Files: \" . implode(', ', $files)";
        }

        if (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user()->first(config('http-logger.action_by_columns'))->toArray();
            $userBody = json_encode($user);
            $message .= " - Action By: {$userBody}";
        }

        $channel = config('http-logger.log_channel');

        Log::channel($channel)->info($message);
    }
}
