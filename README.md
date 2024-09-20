# Laravel Crod

<img src="https://banners.beyondco.de/Laravel%20Crod.png?theme=light&packageManager=composer+require&packageName=milwad%2Flaravel-crod&pattern=architect&style=style_1&description=Generate+crud+files+easy&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg" />

[![PHP Version Require](https://img.shields.io/packagist/dependency-v/milwad/laravel-crod/php.svg)](https://packagist.org/packages/milwad/laravel-crod)
[![Latest Stable Version](https://img.shields.io/packagist/v/milwad/laravel-crod.svg)](https://packagist.org/packages/milwad/laravel-crod)
[![Total Downloads](https://img.shields.io/packagist/dt/milwad/laravel-crod.svg)](https://packagist.org/packages/milwad/laravel-crod)
[![License](https://img.shields.io/packagist/l/milwad/laravel-crod.svg)](https://packagist.org/packages/milwad/laravel-crod)
[![Passed Tests](https://github.com/milwad-dev/laravel-crod/actions/workflows/run-tests.yml/badge.svg)](https://github.com/milwad-dev/laravel-crod/actions/workflows/run-tests.yml)

***
Laravel crod is a package for implementing CRUD faster and easier.
You can quickly create controllers, models, migrations, services, repositories, views and requests.
You can make it automatically fillable for models, query for repositories and services, make resource controllers, and have a lot of options.

Docs: https://github.com/milwad-dev/laravel-crod/wiki

## Requirements

***

- `PHP: ^8.0`
- `Laravel framework: ^9`
- `doctrine/dbal: ^3.6`

| Crod | L7                 | L8                 | L9                 | L10                | L11                |
|------|--------------------|--------------------|--------------------|--------------------|--------------------|
| 1.0  | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                | :x:                |
| 1.1  | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: |
| 1.2  | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: |
| 1.3  | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: |
| 1.4  | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: |

## Installation

***

```bash
composer require milwad/laravel-crod
```

After installation, you need to publish config files. <br>

```bash
php artisan vendor:publish --provider="Milwad\LaravelCrod\LaravelCrodServiceProvider" --tag="laravel-crod-config"
```

## Check active commands

When you install the `Laravel Crod`, a series of commands will be activated for you. For see these commands, you can run below command: <br>

```bash
php artisan
```

![Crod commands](https://s6.uupload.ir/files/carbon_(1)_tqmq.png "Crod commands")

## Make CRUD files

For creating crud files, you need to run the `crud:make` command in your terminal: <br>

```bash
php artisan crud:make {name}
``` 

<br>

For example <br>

```bash
php artisan crud:make Product
```

When you execute this command, after creating the files, you will see a list of options that will create a series of additional files for you, which of course are optional, you can choose and if you need, it will create additional files for you such as `seeder`, `factory`, `repository`, etc.

✅ After, you can see `Laravel Crod` creates crud files such as `Model`, `Controller`, `Form-Requests`, `Migrations` etc.

## CRUD Query

If you run `crud:query` command, the result is:

- Add `index`, `create`, `store`, `edit`, `update`, `destroy` function to your controller
- Get all migration columns and move it to your model fillable
- Add `index`, `findById`, `delete` functions to your repositories
- Add `store`, `update` functions to your services
- Add resource route (SOON)

<strong>** You must run the migrate command, before `crud:query` command. ** </strong> <br>

```bash
php artisan migrate
```

For using automatic query, you can run below command:

```bash
php artisan crud:query {table_name} {model} {--id-controller}
```

For example:

```bash
php artisan crud:query products Product
```

When you add `--id-controller` option, the `Laravel Crod` create crud functions without [Route Model Binding](https://laravel.com/docs/routing#route-model-binding) in controller.

After you can see `Laravel Crod` added query to service, repository, controller, model, etc.

## CRUD for Module

If you are using Modular Architecture, you are able to run `crud:make-module` command. This command create a new module and create the default crud files such as `Model`, `Controller`, `Migration`, etc:

```bash
php artisan crud:make-module {module_name}
```

For example:

```bash
php artisan crud:make-module Product
```

When you execute this command, after creating the files, you will see a list of options that will create a series of additional files for you, which of course are optional, you can choose and if you need, it will create additional files for you such as `seeder`, `factory`, `repository`, etc.

## CRUD Query for Module

This command adds query and date to CRUD files for module.
This command is similar to `crud:query` command, but this command is for module. if you have a modular you can write your module name and `Laravel Crod` find it automatically.

** You must run your migration file **

```
php artisan crud:query-module {table_name} {model} {--id-controller}
```

For example:

```bash
php artisan crud:query-module products Product
```

OR

```bash
php artisan crud:query-module products Product --id-controller
```

When you add `--id-controller` option, the `Laravel Crod` create crud functions without [Route Model Binding](https://laravel.com/docs/routing#route-model-binding) in controller.

After you can see `Laravel Crod` added query to service, repository, controller, model, ... for your module.

## Custom path

You can custom file path in config file. ``````

With `Laravel Crod` config, you can customize the commands, for example you want to set the route file name.
This config file exists in `config/laravel-crod.php`:

```php
<?php

return [
    /*
     * Repository namespace.
     *
     * This is a word that move into the latest name of repository file, for ex: ProductRepo.
     * If this value is changed, any repos that are created will be renamed, for ex: ProductRepository.
    */
    'repository_namespace' => 'Repo',

    /*
     * Get main controller.
     *
     * This is a namespace of main controller that default path is `App\Http\Controllers\Controller`.
     */
    'main_controller' => 'App\Http\Controllers\Controller',

    /*
     * Are using PEST?
     *
     * If you are using PEST framework, you can change it this value to `true`.
     */
    'are_using_pest' => false,

    /*
     * Route namespace.
     *
     * This is a word that move into the latest name of route file.
     */
    'route_namespace' => '',

    /*
     * Route name.
     *
     * This is a word that name of route file.
     */
    'route_name' => 'web',

    /*
     * Modules config.
     *
     * You can make custom modules with special folders ... .
     */
    'modules' => [
        'module_namespace'  => 'Modules', // This value is for the name of the folder that the modules are in.
        'model_path'        => 'Entities', // This value is for the name of the folder that contains the module models.
        'migration_path'    => 'Database\Migrations', // This value is for the name of the folder that contains the module migrations.
        'controller_path'   => 'Http\Controllers', // This value is for the name of the folder that contains the module controllers.
        'request_path'      => 'Http\Requests', // This value is for the name of the folder that contains the module requests-form.
        'view_path'         => 'Resources\Views', // This value is for the name of the folder that contains the module views.
        'service_path'      => 'Services', // This value is for the name of the folder that contains the module services.
        'repository_path'   => 'Repositories', // This value is for the name of the folder that contains the module Repositories.
        'feature_test_path' => 'Tests\Feature', // This value is for the name of the folder that contains the module feature-tests.
        'unit_test_path'    => 'Tests\Unit', // This value is for the name of the folder that contains the module unit-tests.
        'provider_path'     => 'Providers', // This value is for the name of the folder that contains the module providers.
        'factory_path'      => 'Database\Factories', // This value is for the name of the folder that contains the module factories.
        'seeder_path'       => 'Database\Seeders', // This value is for the name of the folder that contains the module seeders.
        'route_path'        => 'Routes', // This value is for the name of the folder that contains the module routes.
    ],

    /*
     * Queries.
     *
     * This is some config for add queries.
     */
    'queries' => [
        /*
         * Except columns in fillable.
         *
         * This `except_columns_in_fillable` must be arrayed!
         * This `except_columns_in_fillable` that remove field from $fillable in model.
         */
        'except_columns_in_fillable' => [
            'id', 'updated_at', 'created_at',
        ],
    ],
];
```

## License

* This package is created and modified by <a href="https://github.com/milwad-dev" target="_blank">Milwad Khosravi</a>
  for Laravel >= 9 and is released under the MIT License.

## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
composer test
composer test-coverage
```

## Contributing

This project exists thanks to all the people who
contribute. [CONTRIBUTING](https://github.com/milwad-dev/laravel-crod/graphs/contributors)

<a href="https://github.com/milwad-dev/laravel-crod/graphs/contributors"><img src="https://opencollective.com/laravel-crod/contributors.svg?width=890&button=false" /></a>

## Security

If you've found a bug regarding security please mail [milwad.dev@gmail.com](mailto:milwad.dev@gmail.com) instead of
using the issue tracker.

## Conclusion

Laravel-crod is a simple yet powerful package that can help you create CRUD operations for your Laravel models in just a few lines of code. By following this documentation, you should now have a better understanding of how to use the package in your Laravel project. If you have any issues or questions, please feel free to open an issue on the package's GitHub repository.
