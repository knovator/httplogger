<?php

return [

    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \knovator\logger\src\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \knovator\logger\src\DefaultLogWriter::class,

    /*
     * Filter out body fields which will never be logged.
     */
    'except' => [
        'password',
        'password_confirmation',
    ],

    /* Default log channel.*/
    'log_channel' => 'custom_log',

    /* Default log period.*/
    'log_period' => 'daily',

    /* Default log file name.*/
    'log_file_name' => 'custom',

];
