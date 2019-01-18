<?php

namespace knovator\logger\src;

use Illuminate\Support\ServiceProvider;

/**
 * Class HttpLoggerServiceProvider
 * @package knovator\logger\src
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

        $this->app->singleton(LogProfile::class, config('http-logger.log_profile'));
        $this->app->singleton(LogWriter::class, config('http-logger.log_writer'));
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/http-logger.php', 'http-logger');
    }
}
