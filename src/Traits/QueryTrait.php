<?php

namespace Milwad\LaravelCrod\Traits;

use Illuminate\Support\Arr;

trait QueryTrait
{
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
}