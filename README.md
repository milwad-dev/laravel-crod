# Laravel crod
***
Laravel crod is a package for help to make crud fast & easy.
You can make controller model migration services repositories views request fast.
You can make automatically fillable for model, query for repositories & services, make resources function for controllers.

# Requirements
***
- PHP >= 8.0
- doctrine/dbal > 3.3

# Installation
***
Run the Composer update command. <br>
``composer require milwad/laravel-crod``

# Check active commands
Run the command in cmd or terminal. <br>
``php artisan``<br>

You must see this command in cmd or terminal.
![Crod commands](https://s6.uupload.ir/files/carbon_(1)_on5l.png "Crod commands")

# Make crud files
<font color="succe">This command create crud files.</font> <br>
Run the command in cmd or terminal. <br>
``php artisan crud:make {name} {--service} {--repo}``<br>

For example <br>
``php artisan crud:make Product --service --repo``<br>

<font color="info">After you can see crod create files for crud.</font>

# Crud query
<font color="succe">This command add query & date to crud files.</font> <br>
<font color="yellow">** You must migrate your migration file. ** </font> <br>
Run the command in cmd or terminal. <br>
``php artisan crud:query {table_name} {model}``<br>

For example <br>
``php artisan crud:query products Product``<br>

<font color="info">After you can see add query to service, repository, controller, model, etc.</font>

# License 
* This package is created and modified by <a href="https://github.com/milwad-dev" target="_blank">Milwad Khosravi</a> for Laravel >= 9 and is released under the MIT License.
