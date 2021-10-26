<?php
namespace Deegitalbe\ServerAuthorization\Tests;

use Henrotaym\LaravelTestSuite\TestSuite;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Deegitalbe\ServerAuthorization\Providers\ServerAuthorizationServiceProvider;

class TestCase extends BaseTestCase
{
    use
        TestSuite
    ;
    
    /**
     * Providers used bu application (manual registration is compulsory)
     * 
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServerAuthorizationServiceProvider::class
        ];
    }
}