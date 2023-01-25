<?php

namespace Milwad\LaravelCrod\Datas;

/*
 * This file is for add data in crud files.
 *
 * ======================== WARNING ======================== => DO NOT MAKE ANY CHANGES TO THIS FILE
 */
class QueryData
{
    public static function getModelData(mixed $items)
    {
        return PHP_EOL . '    protected $fillable = [' . $items . '];' . PHP_EOL . '}';
    }
}