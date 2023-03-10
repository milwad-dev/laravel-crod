<?php

namespace Milwad\LaravelCrod\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelCrodServiceFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-crod-service';
    }
}