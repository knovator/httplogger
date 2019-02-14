<?php

namespace Knovators\HttpLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $bodyAsJson = json_encode($this->input($request, config('http-logger.except')));
        $message = "{$method} {$uri} - Action From: {$this->clientInformation($request)} - Body: {$bodyAsJson}";
        $this->uploadedFiles($request->files, $fileNames);

        if (!empty($fileNames)) {
            $message .= " - Files: " . json_encode($fileNames);
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

    /**
     * Get all of the input except for a specified array of items.
     *
     * @param              $request
     * @param  array|mixed $expectKeys
     * @return array
     */
    private function input($request, $expectKeys) {
        /** @var Request $request */
        $results = $request->input();
        Arr::forget($results, $expectKeys);

        return $results;
    }

    /**
     * @param $request
     * @return mixed
     */
    private function clientInformation($request) {
        /** @var Request $request */
        $response['agent'] = $request->header('user-agent');
        $response['ip'] = $request->ip();
        return json_encode($response);

    }

    /**
     * @param      $requestFiles
     * @param      $fileNames
     * @param bool $parentKey
     */
    private function uploadedFiles($requestFiles, &$fileNames, $parentKey = false) {
        if (!is_array($requestFiles)) {
            $requestFiles = iterator_to_array($requestFiles);
        }
        foreach ($requestFiles as $fileKey => $file) {
            if (is_array($file)) {
                $this->uploadedFiles($file, $fileNames, $fileKey);
            } elseif ($parentKey) {
                $fileNames[$parentKey][$fileKey] = $file->getClientOriginalName();
            } else {
                $fileNames[$fileKey] = $file->getClientOriginalName();
            }

        }

    }
}
