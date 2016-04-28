<?php

namespace Ageras\LaravelOneSky;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Onesky\Api\Client;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
        $this->registerClient();
    }

    public function boot()
    {
        $this->loadConfiguration();
    }

    public function registerCommands()
    {
        $this->app->bindIf('command.onesky', function () {
            return new Commands\OneSky();
        });
        $this->app->bindIf('command.onesky.pull', function () {
            return new Commands\Pull();
        });
        $this->app->bindIf('command.onesky.push', function () {
            return new Commands\Push();
        });

        $this->commands(
            'command.onesky',
            'command.onesky.pull',
            'command.onesky.push'
        );
    }

    public function registerClient()
    {
        $this->app->bindIf('onesky', function() {
            return (new Client())
                ->setApiKey(getenv('ONESKY_API_KEY'))
                ->setSecret(getenv('ONESKY_SECRET'));
        });
    }

    /**
     * Load the configuration files and allow them to be published.
     *
     * @return void
     */
    protected function loadConfiguration()
    {
        $configPath = __DIR__ . '/../config/onesky.php';

        $this->publishes([
            $configPath => config_path('onesky.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'onesky');
    }
}
