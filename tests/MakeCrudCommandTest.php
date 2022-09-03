<?php

namespace Milwad\LaravelCrod\Commands;

use Milwad\LaravelCrod\LaravelCrodServiceProvider;

class MakeCrudCommandTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array<int, string>
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelCrodServiceProvider::class
        ];
    }
}
