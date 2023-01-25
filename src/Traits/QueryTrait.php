<?php

namespace Milwad\LaravelCrod\Traits;

use Illuminate\Support\Arr;
use Milwad\LaravelCrod\Datas\QueryData;

trait QueryTrait
{
    use AddDataToRepoTrait, AddDataToServiceTrait;

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
     * @param mixed $items
     * @param mixed $filename
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
     * @param string $model
     * @param string $filename
     * @return void
     */
    private function addDataToController(string $model, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename);
        $lines[$line_i_am_looking_for] = $this->option('id-controller')
            ? $this->controllerId()
            : $this->controllerRouteModelBinding($model);

        file_put_contents($filename, implode("\n", $lines));
    }

    /**
     * @param string $filename
     * @param int $looking_for
     * @return array
     */
    private function lookingLinesWithIgnoreLines(string $filename, int $looking_for = 8): array
    {
        return [
            $looking_for,
            file($filename, FILE_IGNORE_NEW_LINES)
        ];
    }
}