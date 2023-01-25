<?php

namespace Milwad\LaravelCrod\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Milwad\LaravelCrod\Datas\QueryData;
use Milwad\LaravelCrod\Traits\QueryTrait;

class MakeQueryCommand extends Command
{
    use QueryTrait;

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

        $this->addDataToModel($items, "App/Models/$model.php");
        $this->addDataToController($model, "App/Http/Controllers/{$model}Controller.php");

        if (File::exists($filename = "App/Services/{$model}Service.php")) {
            $this->addDataToService($model, $filename);
        }
        if (File::exists($filename = "App/Repositories/{$model}Repo.php")) {
            $this->addDataToRepo($model, $filename);
        }

        $this->info('Query added successfully');
    }

    /**
     * Add data to controller with $id.
     *
     * @return string
     */
    private function controllerId(): string
    {
        return QueryData::getControllerIdData(
            '// Start code - milwad-dev',
            '$request',
            '$id'
        );
    }

    /**
     * Add data to controller with route model binding.
     *
     * @param string $name
     * @return string
     */
    private function controllerRouteModelBinding(string $name): string
    {
        return QueryData::getControllerRouteModelBinding(
            '// Start code - milwad-dev',
            '$request',
            $name,
            strtolower($name)
        );
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

        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 3);
        $lines[$line_i_am_looking_for] = QueryData::getUseServiceData($model);

        file_put_contents($filename, implode("\n", $lines));
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

        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 3);
        $lines[$line_i_am_looking_for] = QueryData::getUseRepoData($model);

        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * @param string $filename
     * @param int $looking_for
     * @return array
     */
    public function lookingLinesWithIgnoreLines(string $filename, int $looking_for = 8): array
    {
        return [
            $looking_for,
            file($filename, FILE_IGNORE_NEW_LINES)
        ];
    }
}
