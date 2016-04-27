<?php

namespace Ageras\LaravelOneSky;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

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
    }
}
