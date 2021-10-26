<?php
namespace Deegitalbe\ServerAuthorization\Tests\Unit\Facade;

use Illuminate\Support\Facades\Log;
use Deegitalbe\ServerAuthorization\Tests\TestCase;
use Deegitalbe\ServerAuthorization\Facades\Package;
use Deegitalbe\ServerAuthorization\Exceptions\NoAuthorizationKey;

class PackageTest extends TestCase
{
    /**
     * @test
     */
    public function package_facade_returning_config_authorization_key()
    {
        $value = ":test";
        $this->setPackageConfig('authorization_value', $value);

        $this->assertEquals($value, Package::authorization());
    }

    /**
     * @test
     */
    public function package_facade_returning_config_authorization_header()
    {
        $value = ":test";
        $this->setPackageConfig('authorization_header', $value);

        $this->assertEquals($value, Package::header());
    }

    /**
     * @test
     */
    public function package_facade_creating_log_if_no_authorization_key()
    {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(function($message) {
               return (new NoAuthorizationKey())->getMessage() === $message;
            });

        $this->assertEquals("", Package::authorization());
    }

    /**
     * Setting package config value.
     * 
     * @param string $key
     * @param mixed $value
     * @return self
     */
    protected function setPackageConfig(string $key, $value): self
    {
        config([Package::prefix() . ".$key" => $value]);

        return $this;
    }
}