<?php

return [

    /*
     * Filter out body fields which will never be logged.
     */
    'except' => [
        'password',
        'password_confirmation',
    ],

    /* Default log channel.*/
    'log_channel' => 'custom_log',

];
