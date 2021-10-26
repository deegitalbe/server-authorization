<?php
namespace Deegitalbe\ServerAuthorization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade allowing to manipulate package.
 */
class Package extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'trustup-server-authorization';
    }
}