# Laravel Crod

![milwad-dev larave-crod](https://preview.dragon-code.pro/milwad-dev/larave-crod.svg?brand=laravel&invert=1)

[![Latest Stable Version](http://poser.pugx.org/milwad/laravel-crod/v)](https://packagist.org/packages/milwad/laravel-crod)
[![Total Downloads](http://poser.pugx.org/milwad/laravel-crod/downloads)](https://packagist.org/packages/milwad/laravel-crod)
[![License](http://poser.pugx.org/milwad/laravel-crod/license)](https://packagist.org/packages/milwad/laravel-crod)
[![Passed Tests](https://github.com/milwad-dev/laravel-crod/actions/workflows/run-tests.yml/badge.svg)](https://github.com/milwad-dev/laravel-crod/actions/workflows/run-tests.yml)
[![PHP Version Require](http://poser.pugx.org/milwad/laravel-crod/require/php)](https://packagist.org/packages/milwad/laravel-crod)

***
Laravel crod is a package for implementing CRUD faster and easier. <br>
You can create controllers, models, migrations, services, repositories, views and requests quickly. <br>
You can make automatically fillable for models, query for repositories and services, make resource functions for
controllers, and a lot of options.

Docs: https://github.com/milwad-dev/laravel-crod/wiki

# Requirements

***

- `PHP: ^8.0`
- `Laravel framework: ^9`
- `doctrine/dbal: ^3.6`

| Crod | L7                 | L8                 | L9                 | L10                |
|------|--------------------|--------------------|--------------------|--------------------|
| 1.0  | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                |
| 1.1  | :x:                | :x:                | :white_check_mark: | :white_check_mark: |
| 1.2  | :x:                | :x:                | :white_check_mark: | :white_check_mark: |

# Installation

***

```bash
composer require milwad/laravel-crod
```

After publish config files.<br>

```bash
php artisan vendor:publish --provider="Milwad\LaravelCrod\LaravelCrodServiceProvider" --tag="laravel-crod-config"
```

# Check active commands

Run the command in cmd or terminal. <br>

```bash
php artisan
```

<br>

You must see this command in the terminal.
![Crod commands](https://s6.uupload.ir/files/carbon_(1)_tqmq.png "Crod commands")

# Make CRUD files

<font color="succe">This command creates CRUD files</font>, Run this command in the terminal. <br>

```bash
php artisan crud:make {name}
``` 

<br>

For example <br>

```bash
php artisan crud:make Product
```

When you execute this command, after creating the files, you will see a list of options that will create a series of additional files for you, which of course are optional, you can choose and if you need, it will create additional files for you such as `seeder`, `factory`, `repository`, etc.

✅ After you can see crod creates files for crud

# CRUD query

This command adds query and date to CRUD files. <br>

<strong>** You must run the migrate command. ** </strong> <br>

```bash
php artisan migrate
```

Run this command in the terminal. <br>

```bash
php artisan crud:query {table_name} {model} {--id-controller}
```

For example

```bash
php artisan crud:query products Product
```

When write `--id-controller` option add function without route model binding.

<font color="info">After you can see add query to service, repository, controller, model, etc.</font>

# CRUD for module

Run this command in the terminal, This command created CRUD file for module.

```bash
php artisan crud:make-module {module_name}
```

For example

```bash
php artisan crud:make-module Product
```

When you execute this command, after creating the files, you will see a list of options that will create a series of additional files for you, which of course are optional, you can choose and if you need, it will create additional files for you such as `seeder`, `factory`, `repository`, etc.

# CRUD query from module

<font color="succe">This command adds query and date to CRUD files for module.</font> <br>

<font color="yellow">** You must run your migration file. ** </font> <br>

```
php artisan crud:query-module {table_name} {model} {--id-controller}
```

For example

```bash
php artisan crud:query-module products Product
```

OR

```bash
php artisan crud:query-module products Product --id-controller
```

When write --id-controller option add function without route model binding.

<font color="info">After you can see add query to service, repository, controller, model, etc for module.</font>

## Custom path

You can custom file path in config file. ```config/laravel-crod.php```

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
     * Modules config.
     *
     * You can make custom modules with special folders ... .
     */
    'modules' => [
        'module_namespace' => 'Modules', // This value is for the name of the folder that the modules are in.
        'model_path' => 'Entities', // This value is for the name of the folder that contains the module models.
        'migration_path' => 'Database\Migrations', // This value is for the name of the folder that contains the module migrations.
        'controller_path' => 'Http\Controllers', // This value is for the name of the folder that contains the module controllers.
        'request_path' => 'Http\Requests', // This value is for the name of the folder that contains the module requests-form.
        'view_path' => 'Resources\Views', // This value is for the name of the folder that contains the module views.
        'service_path' => 'Services', // This value is for the name of the folder that contains the module services.
        'repository_path' => 'Repositories', // This value is for the name of the folder that contains the module Repositories.
        'feature_test_path' => 'Tests\Feature', // This value is for the name of the folder that contains the module feature-tests.
        'unit_test_path' => 'Tests\Unit', // This value is for the name of the folder that contains the module unit-tests.
        'provider_path' => 'Providers', // This value is for the name of the folder that contains the module providers.
        'factory_path' => 'Database\Factories', // This value is for the name of the folder that contains the module factories.
        'seeder_path' => 'Database\Seeders', // This value is for the name of the folder that contains the module seeders.
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

This config file is very helpful to custom path or latest name file.

## License

* This package is created and modified by <a href="https://github.com/milwad-dev" target="_blank">Milwad Khosravi</a>
  for Laravel >= 9 and is released under the MIT License.

## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
composer test
composer coverage
```

## Contributing

This project exists thanks to all the people who
contribute. [CONTRIBUTING](https://github.com/milwad-dev/laravel-crod/graphs/contributors)

<a href="https://github.com/imanghafoori1/laravel-microscope/graphs/contributors"><img src="https://opencollective.com/laravel-crod/contributors.svg?width=890&button=false" /></a>

## Security

If you've found a bug regarding security please mail [milwad.dev@gmail.com](mailto:milwad.dev@gmail.com) instead of
using the issue tracker.

## Conclusion

Laravel-crod is a simple yet powerful package that can help you create CRUD operations for your Laravel models in just a few lines of code. By following this documentation, you should now have a better understanding of how to use the package in your Laravel project. If you have any issues or questions, please feel free to open an issue on the package's GitHub repository.
