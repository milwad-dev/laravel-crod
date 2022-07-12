<?php

namespace Milwad\LaravelCrod\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class MakeCrudQueryCommand extends Command
{
    protected $signature = 'crud:query {table_name} {model}';

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

        $filename = "App/Services/{$model}Service.php";
        if (File::exists($filename)) {
            $this->addDataToService($model);
        }

        $filename = "App/Repositories/{$model}Repo.php";
        if (File::exists($filename)) {
            $this->addDataToRepo($model);
        }

        $this->info('Query added successfully');
    }

    /**
     * Add data to model.
     *
     * @param string $model
     * @param $items
     * @return void
     */
    private function addDataToModel(string $model, $items)
    {
        $filename = "App/Models/$model.php";
        $line_i_am_looking_for = 10;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = PHP_EOL . '    protected $fillable = [' . $items . '];' . PHP_EOL . '}';
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add db column to string.
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
     * Add data to service.
     *
     * @param string $model
     * @return void
     */
    private function addDataToService(string $model)
    {
        $filename = "App/Services/{$model}Service.php";
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
     * Add use to Service.
     *
     * @param $model
     * @return void
     */
    private function addUseToService($model)
    {
        $filename = "App/Services/{$model}Service.php";
        $line_i_am_looking_for = 3;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = "
use App\Models\{$model};
";
        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to repository.
     *
     * @param string $model
     * @return void
     */
    private function addDataToRepo(string $model)
    {
        $filename = "App/Repositories/{$model}Repo.php";
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
     * Add use to repository.
     *
     * @param $model
     * @return void
     */
    private function addUseToRepo($model)
    {
        $filename = "App/Repositories/{$model}Repo.php";
        $line_i_am_looking_for = 3;
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $lines[$line_i_am_looking_for] = "
use App\Models\{$model};
";
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
        $comment = '// Start code - milwad-dev';
        $id = '$id';
        $request = '$request';
        $lines[$line_i_am_looking_for] = "    public function index()
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
        file_put_contents($filename, implode("\n", $lines));
    }
}
