<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Milwad\LaravelCrod\Datas\QueryData;

class MakeQueryCommand extends Command
{
    protected $signature = 'crud:query {table_name} {model} {--id-controller}';

    protected $description = 'Add query & data fast';

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

        $this->addDataToModel($model, $items);
        $this->addDataToController($model);

        if (File::exists($filename = "App/Services/{$model}Service.php")) {
            $this->addDataToService($model, $filename);
        }
        if (File::exists($filename = "App/Repositories/{$model}Repo.php")) {
            $this->addDataToRepo($model, $filename);
        }

        $this->info('Query added successfully');
    }

    /**
     * Add db column to string.
     *
     * @param array $itemsDB
     * @return string
     * @throws \Exception
     */
    private function addDBCulumnsToString(array $itemsDB)
    {
        $columns = '';
        $excepts = config('laravel-crod.queries.except_columns_in_fillable');

        if (! is_array($excepts)) {
            throw new \RuntimeException("Except columns is not an array");
        }

        foreach ($excepts as $except) {
            if (Arr::exists($itemsDB, $except)) {
                Arr::forget($itemsDB, $except);
            }
        }
        foreach ($itemsDB as $db) {
            $columns .= "'$db', ";
        }

        return $columns;
    }

    /**
     * Add data to model.
     *
     * @param string $model
     * @param mixed $items
     * @return void
     */
    private function addDataToModel(string $model, mixed $items)
    {
        $filename = "App/Models/$model.php";
        $line_i_am_looking_for = 10;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = QueryData::getModelData($items);
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to service.
     *
     * @param string $model
     * @param string $filename
     * @return void
     */
    private function addDataToService(string $model, string $filename)
    {
        $line_i_am_looking_for = 6;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = QueryData::getServiceData($model, '$request', '$id');
        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToService($model);
    }

    /**
     * Add use to Service.
     *
     * @param string $model
     * @return void
     */
    private function addUseToService(string $model)
    {
        $filename = "App/Services/{$model}Service.php";
        $line_i_am_looking_for = 3;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = QueryData::getUseServiceData($model);
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to repository.
     *
     * @param string $model
     * @param string $filename
     * @return void
     */
    private function addDataToRepo(string $model, string $filename)
    {
        $line_i_am_looking_for = 6;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = QueryData::getRepoData($model, '$id');
        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToRepo($model);
    }

    /**
     * Add use to repository.
     *
     * @param string $model
     * @return void
     */
    private function addUseToRepo(string $model)
    {
        $filename = "App/Repositories/{$model}Repo.php";
        $line_i_am_looking_for = 3;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = QueryData::getUseRepoData($model);
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to controller.
     *
     * @param string $model
     * @return void
     */
    private function addDataToController(string $model)
    {
        $filename = "App/Http/Controllers/{$model}Controller.php";
        $line_i_am_looking_for = 8;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        if (!$this->option('id-controller')) {
            $lines[$line_i_am_looking_for] = $this->controllerRouteModelBinding($model);
        } else {
            $lines[$line_i_am_looking_for] = $this->controllerId();
        }
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to controller with $id.
     *
     * @return string
     */
    private function controllerId(): string
    {
        return QueryData::getControllerIdData("// Start code - milwad-dev", '$request', '$id');
    }

    /**
     * Add data to controller with route model binding.
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
}
