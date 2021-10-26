<?php
/**
 * Package internal config.
 */
return [
    /**
     * Authorization secret key.
     */
    'authorization_value' => env('TRUSTUP_SERVER_AUTHORIZATION'),
    /**
     * Authorization header name.
     */
    'authorization_header' => "X-Server-Authorization",
];