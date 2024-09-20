<?php

namespace Milwad\LaravelCrod\Tests;

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

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::deleteDirectory(base_path('Modules'));
        File::deleteDirectory(base_path('App\Repositories'));
        File::deleteDirectory(base_path('App\Services'));
        File::deleteDirectory(base_path('Database\Factories'));
    }
}
