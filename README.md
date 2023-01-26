# Laravel crod
***
Laravel crod is a package for implementing CRUD faster & easier.
You can create controllers, models, migrations, services, repositories, views and requests quickly.
You can make automatically fillable for models, query for repositories & services, make resource functions for controllers.

# Requirements
***
- PHP >= 7.2
- doctrine/dbal > 3.3
- Laravel framework >= 6

# Installation
***
```bash
composer require milwad/laravel-crod
```
After publish config files.<br>
```bash
php artisan vendor:publish --provider="Milwad\LaravelCrod\LaravelCrodServiceProvider" --tag="config"
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
php artisan crud:make {name} {--service} {--repo} {--test}
``` 
<br>

For example <br>
```bash
php artisan crud:make Product --service --repo --test
```
<br>
<li> When write service option add service file. </li>
<li> When write repo option add repository file. </li>
<li> When write test option add tests file. </li>

✅ After you can see crod creates files for crud

# CRUD query
<font color="succe">This command adds query & date to CRUD files.</font> <br>

<font color="yellow">** You must run the migrate command. ** </font> <br>
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

When write --id-controller option add function without route model binding.

<font color="info">After you can see add query to service, repository, controller, model, etc.</font>

# CRUD for module
Run this command in the terminal, This command created CRUD file for module.
```bash
php artisan crud:make-module {module_name} {--service} {--repo} {--test}
```

For example
```bash
php artisan crud:make-module Product --service --repo --test
```

# CRUD query from module
<font color="succe">This command adds query & date to CRUD files for module.</font> <br>

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
    /**
     * Modules config.
     *
     * You can make custom modules with special folders ...
     */
    'modules' => [
        'module_namespace' => 'Modules',
        'repository_namespace' => 'Repo',

        'model_path' => 'Entities',
        'migration_path' => 'Database\Migrations',
        'controller_path' => 'Http\Controllers',
        'request_path' => 'Http\Requests',
        'view_path' => 'Resources\Views',
        'service_path' => 'Services',
        'repository_path' => 'Repositories',
        'feature_test_path' => 'Tests\Feature',
        'unit_test_path' => 'Tests\Unit',
    ],

    /**
     * Queries.
     */
    'queries' => [
        'except_columns_in_fillable' => [
            'id', 'updated_at', 'created_at'
        ]
    ]
];
```

This config file is very helpful to custom path or latest name file.


## License 
* This package is created and modified by <a href="https://github.com/milwad-dev" target="_blank">Milwad Khosravi</a> for Laravel >= 6 and is released under the MIT License.

## Testing

Run the tests with:

``` bash
vendor/bin/phpunit
composer test
composer coverage
```

## Contributing

This project exists thanks to all the people who contribute. [CONTRIBUTING](https://github.com/milwad-dev/laravel-crod/graphs/contributors)

<a href="https://github.com/imanghafoori1/laravel-microscope/graphs/contributors"><img src="https://opencollective.com/laravel-crod/contributors.svg?width=890&button=false" /></a>

## Security

If you've found a bug regarding security please mail [milwad.dev@gmail.com](mailto:milwad.dev@gmail.com) instead of using the issue tracker.
