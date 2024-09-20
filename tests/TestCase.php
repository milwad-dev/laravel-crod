<?php

namespace Milwad\LaravelCrod\Tests;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\File;
use Milwad\LaravelCrod\LaravelCrodServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array<int, string>
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelCrodServiceProvider::class,
        ];
    }

    /*
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(base_path('Modules'));
        File::deleteDirectory(base_path('modules'));
        File::deleteDirectory(base_path('app\Repositories'));
        File::deleteDirectory(base_path('app\Services'));
        File::deleteDirectory(base_path('database\factories'));
        File::deleteDirectory(base_path('resources\views\products'));
    }

    /*
    * Define environment setup.
    *
    * @param \Illuminate\Foundation\Application $app
    */
    protected function getEnvironmentSetUp($app)
    {
        // Set default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Set app key
        $app['config']->set('app.key', 'base64:'.base64_encode(
            Encrypter::generateKey(config()['app.cipher'])
        ));
    }
}
