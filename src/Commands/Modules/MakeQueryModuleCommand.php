<?php

namespace Milwad\LaravelCrod\Commands\Modules;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Milwad\LaravelCrod\Datas\QueryModuleData;
use Milwad\LaravelCrod\Traits\QueryTrait;

class MakeQueryModuleCommand extends Command
{
    use QueryTrait;

    protected $signature = 'crud:query-module {table_name} {model} {--id-controller}';

    protected $description = 'Add query & data fast';

    public string $module_name_space;

    public function __construct()
    {
        parent::__construct();
        $this->module_name_space = config('laravel-crod.modules.module_namespace', 'Modules');
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $this->alert('Add query...');

        $name = $this->argument('table_name');
        $model = $this->argument('model');

        $itemsDB = Schema::getColumnListing($name);
        $items = $this->addDBColumnsToString($itemsDB);

        $controllerFilename = "$this->module_name_space/$model/Http/Controllers/{$model}Controller.php";

        $this->addDataToModel($items, "$this->module_name_space/$model/Entities/$model.php");
        $this->addDataToController($model, $controllerFilename);
        $this->addDataToProvider($model, $controllerFilename);

        if (!$this->option('id-controller')) {
            $this->addUseToControllerForRouteModelBinding($model, $controllerFilename);
        }
        if (File::exists($filename = "$this->module_name_space/$model/Services/{$model}Service.php")) {
            $uses = "
use $this->module_name_space\\$model\Services\\$model;
";
            $this->addDataToService($model, $filename, $uses);
        }
        if (File::exists($filename = "$this->module_name_space/$model/Repositories/{$model}Repo.php")) {
            $this->addDataToRepo($model, $filename);
        }

        $this->info('Query added successfully');
    }

    /**
     * Add data to controller with $id for module.
     *
     * @return string
     */
    private function controllerId(): string
    {
        return QueryModuleData::getControllerIdData(
            '// Start code - milwad-dev',
            '$request',
            '$id'
        );
    }

    /**
     * Add data to controller with route model binding for module.
     *
     * @param string $name
     * @return string
     */
    private function controllerRouteModelBinding(string $name): string
    {
        return QueryModuleData::getControllerRouteModelBinding(
            '// Start code - milwad-dev',
            '$request',
            $name,
            strtolower($name)
        );
    }

    /**
     * Add use to controller route model binding for module.
     *
     * @param string $model
     * @param string $filename
     * @return void
     */
    private function addUseToControllerForRouteModelBinding(string $model, string $filename)
    {
        $currentController = config('laravel-crod.main_controller', 'App\Http\Controllers\Controller');

        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 5);
        $lines[$line_i_am_looking_for] = "
use $this->module_name_space\\$model\Entities\\$model;
use $currentController;
";
        file_put_contents($filename, implode("\n", $lines));
    }
}
