<?php

namespace Knovators\HttpLogger;

use Illuminate\Support\ServiceProvider;

/**
 * Class HttpLoggerServiceProvider
 * @package knovators\logger\src
 */
class HttpLoggerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/http-logger.php' => config_path('http-logger.php'),
            ], 'config');
        }

        $this->app->singleton(LogProfile::class, LogNonGetRequests::class);
        $this->app->singleton(LogWriter::class, DefaultLogWriter::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/http-logger.php', 'http-logger');
    }
}
