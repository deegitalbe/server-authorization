<?php
namespace Deegitalbe\ServerAuthorization\Providers;

use Illuminate\Support\ServiceProvider;
use Deegitalbe\ServerAuthorization\Facades\Package;
use Deegitalbe\ServerAuthorization\Package as UnderlyingPackage;

class ServerAuthorizationServiceProvider extends ServiceProvider
{
    /**
     * Registering informations in application.
     * 
     * @return void
     */
    public function register()
    {
        $this->bindFacade()
            ->registerConfig();
    }

    /**
     * Booting elements in application.
     * 
     * @return void
     */
    public function boot()
    {
        $this->makeConfigPublishable();
    }

    /**
     * Registering package config.
     * 
     * @return self
     */
    protected function registerConfig(): self
    {
        $this->mergeConfigFrom($this->getConfigPath(), Package::prefix());

        return $this;
    }

    /**
     * Registering package facade.
     * 
     * @return self
     */
    protected function bindFacade(): self
    {
        $this->app->bind('trustup-server-authorization', function($app) {
            return new UnderlyingPackage();
        });

        return $this;
    }

    /**
     * Making package config publishable.
     * 
     * @return self
     */
    protected function makeConfigPublishable(): self
    {
        if ($this->app->runningInConsole()):
            $this->publishes([
              $this->getConfigPath() => config_path(Package::prefix()),
            ], 'config');
        endif;

        return $this;
    }

    /**
     * Getting config path.
     * 
     * @return string
     */
    protected function getConfigPath(): string
    {
        return __DIR__.'/../config/config.php';
    }
}