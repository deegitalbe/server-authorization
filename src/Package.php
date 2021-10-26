<?php
namespace Deegitalbe\ServerAuthorization;

use Illuminate\Support\Collection;
use Deegitalbe\ServerAuthorization\Exceptions\NoAuthorizationKey;
use Deegitalbe\TrustupVersionedPackage\Contracts\Project\ProjectContract;
use Deegitalbe\TrustupVersionedPackage\Contracts\VersionedPackageContract;

class Package
{
    /**
     * Getting package version (useful to make sure projetcs use same version).
     * 
     * @return string
     */
    public function version(): string
    {
        return "1.1.0";
    }

    /**
     * Getting package prefix.
     * 
     * @return string
     */
    public function prefix(): string
    {
        return "trustup-server-authorization";
    }

    /**
     * Getting server authorization allowing to make requests to applications.
     * 
     * @return string
     */
    public function authorization(): string
    {
        $authorization = $this->config('authorization_value');
        
        // Log an error if package is missing authorization key.
        if (!$authorization):
            report(new NoAuthorizationKey);
        endif;

        return $authorization ?? "";
    }

    /**
     * Getting server authorization header name needed to make requests to applications.
     * 
     * @return string
     */
    public function header(): string
    {
        return $this->config('authorization_header');
    }

    /**
     * Getting package config key or general config if no key given.
     * 
     * @param string $key Don't give anything if you want whole config
     * @return mixed
     */
    public function config(string $key = null)
    {
        return config($this->prefix() . ($key ? ".$key" : ""));
    }
}