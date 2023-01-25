<?php

namespace Milwad\LaravelCrod\Tests;

use Milwad\LaravelCrod\LaravelCrodServiceProvider;

class BaseTest extends \Orchestra\Testbench\TestCase
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

    public function test_success()
    {
        $this->assertEquals(1, 1);
    }
}
