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
        $fileNames = [];
        $method = strtoupper($request->getMethod());
        $uri = $request->getPathInfo();
        $bodyAsJson = json_encode($request->except(config('http-logger.except')));
        $this->uploadedFiles($request->files, $fileNames);
        $message = "{$method} {$uri} - Body: {$bodyAsJson}";
        dd($fileNames);
        if (!empty($fileNames)) {
            $message .= " - Files: " . implode(', ', $fileNames);
        }

        if (auth()->guard('api')->check()) {
            $user = auth()->guard('api')->user()->first(config('http-logger.action_by_columns'))
                          ->toArray();
            $userBody = json_encode($user);
            $message .= " - Action By: {$userBody}";
        }

        $channel = config('http-logger.log_channel');

        Log::channel($channel)->info($message);
    }
}
