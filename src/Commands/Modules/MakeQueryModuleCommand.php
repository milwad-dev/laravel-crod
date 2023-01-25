<?php

namespace Milwad\LaravelCrod\Commands\Modules;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class MakeQueryModuleCommand extends Command
{
    protected $signature = 'crud:query-module {table_name} {model} {--id-controller}';

    protected $description = 'Add query & data fast';

    public function handle()
    {
        $this->alert('Add query...');

        $name = $this->argument('table_name');
        $model = $this->argument('model');

        $itemsDB = Schema::getColumnListing($name);
        $items = $this->addDBCulumnsToString($itemsDB);

        $this->addDataToModel($model, $items);
        $this->addDataToController($model);

        if (!$this->option('id-controller')) {
            $this->addUseToControllerForRouteModelBinding($model);
        }

        $filename = "$this->module_name_space/$model/Services/{$model}Service.php";
        if (File::exists($filename)) {
            $this->addDataToService($model);
        }

        $filename = "$this->module_name_space/$model/Repositories/{$model}Repo.php";
        if (File::exists($filename)) {
            $this->addDataToRepo($model);
        }

        $this->info('Query added successfully');
    }

    public string $module_name_space;

    public function __construct()
    {
        parent::__construct();
        $this->module_name_space = config('laravel-crod.module_namespace') ?? 'Modules';
    }

    /**
     * Add db column to string for module.
     *
     * @param array $itemsDB
     * @return string
     */
    private function addDBCulumnsToString(array $itemsDB)
    {
        $columns = '';
        foreach ($itemsDB as $db) {
            $columns .= "'$db', ";
        }

        return $columns;
    }

    /**
     * Add data to model for module.
     *
     * @param string $model
     * @param $items
     * @return void
     */
    private function addDataToModel(string $model, $items)
    {
        $filename = "$this->module_name_space/$model/Entities/$model.php";
        $line_i_am_looking_for = 10;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = PHP_EOL . '    protected $fillable = [' . $items . '];' . PHP_EOL . '}';
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to service for module.
     *
     * @param string $model
     * @return void
     */
    private function addDataToService(string $model)
    {
        $filename = "$this->module_name_space/$model/Services/{$model}Service.php";
        $line_i_am_looking_for = 6;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $request = '$request';
        $id = '$id';
        $lines[$line_i_am_looking_for] = "    public function store($request)
    {
        return $model::query()->create(" . '$request->all()' . ");
    }

    public function update($request, $id)
    {
        return $model::query()->where('id', $id)->update(" . '$request->all()' . ");
    }";
        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToService($model);
    }

    /**
     * Add use to Service for module.
     *
     * @param $model
     * @return void
     */
    private function addUseToService($model)
    {
        $filename = "$this->module_name_space/$model/Services/{$model}Service.php";
        $line_i_am_looking_for = 3;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = "
use $this->module_name_space\\$model\Entities\\$model;
";
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to repository for module.
     *
     * @param string $model
     * @return void
     */
    private function addDataToRepo(string $model)
    {
        $filename = "$this->module_name_space/$model/Repositories/{$model}Repo.php";
        $line_i_am_looking_for = 6;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $id = '$id';
        $lines[$line_i_am_looking_for] = "    public function index()
    {
        return $model::query()->latest();
    }

    public function findById($id)
    {
        return $model::query()->findOrFail($id);
    }

     public function delete($id)
    {
        return $model::query()->where('id', $id)->delete();
    }";
        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToRepo($model);
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
     * Add data to controller for module.
     *
     * @param string $model
     * @return void
     */
    private function addDataToController(string $model)
    {
        $filename = "$this->module_name_space/$model/Http/Controllers/{$model}Controller.php";
        $line_i_am_looking_for = 8;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $comment = '// Start code - milwad-dev';
        $request = '$request';
        if (!$this->option('id-controller')) {
            $lines[$line_i_am_looking_for] = $this->controllerRouteModelBinding($comment, $request, $model);
        } else {
            $lines[$line_i_am_looking_for] = $this->controllerId($comment, $request, '$id');
        }
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
