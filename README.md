# Laravel crod
***
Laravel crod is a package for implementing CRUD faster & easier.
You can create controllers, models, migrations, services, repositories, views and requests quickly.
You can make automatically fillable for models, query for repositories & services, make resource functions for controllers.

# Requirements
***
- PHP >= 8.0
- doctrine/dbal > 3.3

# Installation
***
```
composer require milwad/laravel-crod
```

# Check active commands
Run the command in cmd or terminal. <br>
```
php artisan
```
<br>

After publish config files.<br>
```
php artisan vendor:publish --provider="Milwad\LaravelCrod\LaravelCrodServiceProvider" --tag="config"
```

You must see this command in the terminal.
![Crod commands](https://s6.uupload.ir/files/carbon_(1)_tqmq.png "Crod commands")

# Make CRUD files
<font color="succe">This command creates CRUD files.</font> <br>
Run this command in the terminal. <br>
```
php artisan crud:make {name} {--service} {--repo} {--test}
``` 
<br>

For example <br>
```
php artisan crud:make Product --service --repo --test
```
<br>
When write service option add service file. <br>
When write repo option add repository file. <br>
When write test option add tests file.

<font color="info">After you can see crod creates files for crud.</font>

# CRUD query
<font color="succe">This command adds query & date to CRUD files.</font> <br>

<font color="yellow">** You must run your migration file. ** </font> <br>

Run this command in the terminal. <br>
```
php artisan crud:query {table_name} {model} {--id-controller}
```
<br>

For example <br>
```
php artisan crud:query products Product
```
<br>
When write --id-controller option add function without route model binding.

<font color="info">After you can see add query to service, repository, controller, model, etc.</font>

# CRUD for module
Run this command in the terminal. <br>
This command created CRUD file for module.
```
php artisan crud:make-module {module_name} {--service} {--repo} {--test}
```

For example
```
php artisan crud:make-module Product --service --repo --test
```

# CRUD query from module
<font color="succe">This command adds query & date to CRUD files for module.</font> <br>

<font color="yellow">** You must run your migration file. ** </font> <br>
```
php artisan crud:query-module {table_name} {model} {--id-controller}
```

For example
```
php artisan crud:query-module products Product
```
OR
```
php artisan crud:query-module products Product --id-controller
```
When write --id-controller option add function without route model binding.

<font color="info">After you can see add query to service, repository, controller, model, etc for module.</font>

# License 
* This package is created and modified by <a href="https://github.com/milwad-dev" target="_blank">Milwad Khosravi</a> for Laravel >= 9 and is released under the MIT License.
