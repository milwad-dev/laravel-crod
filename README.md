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

You must see this command in the terminal.
![Crod commands](https://s6.uupload.ir/files/carbon_(1)_on5l.png "Crod commands")

# Make CRUD files
<font color="succe">This command creates CRUD files.</font> <br>
Run this command in the terminal. <br>
```
php artisan crud:make {name} {--service} {--repo}
``` 
<br>

For example <br>
```
php artisan crud:make Product --service --repo
```
<br>

<font color="info">After you can see crod creates files for crud.</font>

# Crud query
<font color="succe">This command adds query & date to CRUD files.</font> <br>

<font color="yellow">** You must run your migration file. ** </font> <br>

Run this command in the terminal. <br>
```
php artisan crud:query {table_name} {model}
```
<br>

For example <br>
```
php artisan crud:query products Product
```
<br>

<font color="info">After you can see add query to service, repository, controller, model, etc.</font>

# License 
* This package is created and modified by <a href="https://github.com/milwad-dev" target="_blank">Milwad Khosravi</a> for Laravel >= 9 and is released under the MIT License.
# laravel-crod
Make easy &amp; fast CRUD
