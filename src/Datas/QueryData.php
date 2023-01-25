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

    public static function getServiceData(string $model, string $request, string $id)
    {
        return "    public function store($id)
    {
        return $model::query()->create(" . '$request->all()' . ");
    }

    public function update($request, $id)
    {
        return $model::query()->where('id', $id)->update(" . '$request->all()' . ");
    }";
    }

    public static function getUseServiceData(string $model)
    {
        return "
use App\Models\{$model};
";
    }

    public static function getRepoData(string $model, string $id)
    {
        return "    public function index()
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
    }

}