<?php

namespace Milwad\LaravelCrod;

use Illuminate\Support\ServiceProvider;
use Milwad\LaravelCrod\Console\{MakeCrudPackage, MakeCrudQueryCommand};

class LaravelCrodServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeCrudPackage::class,
            MakeCrudQueryCommand::class,
        ]);
    }
}
