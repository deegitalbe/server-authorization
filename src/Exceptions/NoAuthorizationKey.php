<?php
namespace Deegitalbe\ServerAuthorization\Exceptions;

use Exception;

/**
 * Error representing a missing autorization key in package config.
 */
class NoAuthorizationKey extends Exception
{
    /**
     * Exception message.
     * 
     * @var string
     */
    protected $message = "Trustup server authorization package is missing required secret key. Please add TRUSTUP_SERVER_AUTHORIZATION in you environment.";
}