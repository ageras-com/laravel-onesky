<?php

namespace Ageras\LaravelOneSky\Tests;

use Ageras\LaravelOneSky\ServiceProvider;
use Ageras\LaravelOneSky\Tests\Support\Client;
use Dotenv\Loader;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        (new Loader(__DIR__.'/../.env'))->load();
        $app->singleton('onesky', function() {
            return new Client();
        });

        $onesky = require(__DIR__ . '/../config/onesky.php');
        $onesky['translations_path'] = __DIR__ . '/stubs/lang';
        $app['config']['onesky'] = $onesky;

        $app->register(ServiceProvider::class, [], true);
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
