<?php

namespace Milwad\LaravelCrod\Commands\Modules;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
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
        $this->module_name_space = config('laravel-crod.modules.module_namespace') ?? 'Modules';
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
        $items = $this->addDBCulumnsToString($itemsDB);

        $this->addDataToModel($items, "$this->module_name_space/$model/Entities/$model.php");
        $this->addDataToController($model, "$this->module_name_space/$model/Http/Controllers/{$model}Controller.php");

        if (!$this->option('id-controller')) {
            $this->addUseToControllerForRouteModelBinding($model);
        }
        if (File::exists($filename = "$this->module_name_space/$model/Services/{$model}Service.php")) {
            $this->addDataToService($model, $filename);
        }
        if (File::exists($filename = "$this->module_name_space/$model/Repositories/{$model}Repo.php")) {
            $this->addDataToRepo($model, $filename);
        }

        $this->info('Query added successfully');
    }

    /**
     * Add use to repository for module.
     *
     * @param $model
     * @return void
     */
    private function addUseToRepo($model)
    {
        $filename = "$this->module_name_space/$model/Repositories/{$model}Repo.php";
        $line_i_am_looking_for = 3;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = "
use $this->module_name_space\\$model\Entities\\$model;
";
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to controller with $id for module.
     *
     * @param string $comment
     * @param string $request
     * @param string $id
     * @return string
     */
    private function controllerId(string $comment, string $request, string $id): string
    {
        return "    public function index()
    {
        $comment
    }

    public function create()
    {
        $comment
    }

    public function store(Request $request)
    {
        $comment
    }

    public function edit($id)
    {
        $comment
    }

    public function update(Request $request, $id)
    {
        $comment
    }

    public function destroy($id)
    {
        $comment
    }";
    }

    /**
     * Add data to controller with route model binding for module.
     *
     * @param string $comment
     * @param string $request
     * @param string $name
     * @return string
     */
    private function controllerRouteModelBinding(string $comment, string $request, string $name): string
    {
        $lowerName = strtolower($name);

        return "    public function index()
    {
        $comment
    }

    public function create()
    {
        $comment
    }

    public function store(Request $request)
    {
        $comment
    }

    public function edit($name $$lowerName)
    {
        $comment
    }

    public function update(Request $request, $name $$lowerName)
    {
        $comment
    }

    public function destroy($name $$lowerName)
    {
        $comment
    }";
    }

    /**
     * Add use to controller route model binding for module.
     *
     * @param $model
     * @return void
     */
    private function addUseToControllerForRouteModelBinding($model)
    {
        $filename = "$this->module_name_space/$model/Http/Controllers/{$model}Controller.php";
        $line_i_am_looking_for = 5;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = "
use $this->module_name_space\\$model\Entities\\$model;
use App\Http\Controllers\Controller;
";
        file_put_contents($filename, implode("\n", $lines));
    }
}
