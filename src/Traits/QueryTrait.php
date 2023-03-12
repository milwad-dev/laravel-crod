<?php

namespace Milwad\LaravelCrod\Traits;

use Milwad\LaravelCrod\Datas\QueryData;

trait QueryTrait
{
    use AddDataToRepoTrait;
    use AddDataToServiceTrait;

    /**
     * Add db column to string.
     *
     *
     * @return string
     *
     * @throws \Exception
     */
    private function addDBColumnsToString(array $itemsDB)
    {
        $columns = '';
        $excepts = config('laravel-crod.queries.except_columns_in_fillable', ['id', 'updated_at', 'created_at']);

        if (! is_array($excepts)) {
            throw new \RuntimeException('Except columns is not an array');
        }

        foreach ($excepts as $except) {
            $key = array_search($except, $itemsDB, true);
            unset($itemsDB[$key]);
        }

        foreach ($itemsDB as $db) {
            $columns .= "'$db', ";
        }

        return $columns;
    }

    /**
     * Add data to model.
     *
     * @param  mixed  $filename
     * @return void
     */
    private function addDataToModel(mixed $items, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 10);

        $lines[$line_i_am_looking_for] = QueryData::getModelData($items);

        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to controller.
     *
     *
     * @return void
     */
    private function addDataToController(string $model, string $filename, int $line = 8)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, $line);
        $lines[$line_i_am_looking_for] = $this->option('id-controller')
            ? $this->controllerId()
            : $this->controllerRouteModelBinding($model);

        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * Add data to provider.
     *
     *
     * @return void
     */
    private function addDataToProvider(string $moduleName, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 16);
        $lines[$line_i_am_looking_for] = QueryData::getProviderData($moduleName);

        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * @param  string $filename
     * @param  int $looking_for
     * @return array
     */
    private function lookingLinesWithIgnoreLines(string $filename, int $looking_for = 8): array
    {
        return [
            $looking_for,
            file($filename, FILE_IGNORE_NEW_LINES),
        ];
    }
}
