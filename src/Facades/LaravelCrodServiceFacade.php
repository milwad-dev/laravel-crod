<?php

namespace Milwad\LaravelCrod\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCurrentNameWithCheckLatestLetter(string $name, bool $needToLower = true)
 */
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