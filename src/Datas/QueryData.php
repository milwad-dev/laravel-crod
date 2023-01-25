<?php

namespace Milwad\LaravelCrod\Datas;

/*
 * This file is for add data in crud files.
 *
 * ======================== WARNING ======================== => DO NOT MAKE ANY CHANGES TO THIS FILE
 */
class QueryData
{
    /**
     * Get model data.
     *
     * @param mixed $items
     * @return string
     */
    public static function getModelData(mixed $items)
    {
        return PHP_EOL . '    protected $fillable = [' . $items . '];' . PHP_EOL . '}';
    }

    /**
     * Get service data.
     *
     * @param string $model
     * @param string $request
     * @param string $id
     * @return string
     */
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

    /**
     * Get use for service.
     *
     * @param string $model
     * @return string
     */
    public static function getUseServiceData(string $model)
    {
        return "
use App\Models\{$model};
";
    }

    /**
     * Get repo data.
     *
     * @param string $model
     * @param string $id
     * @return string
     */
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

    /**
     * Get repo for data.
     *
     * @param string $model
     * @return string
     */
    public static function getUseRepoData(string $model)
    {
        return "
use App\Models\{$model};
";
    }

    /**
     * Get controller-id data.
     *
     * @param string $comment
     * @param string $request
     * @param string $id
     * @return string
     */
    public static function getControllerIdData(string $comment, string $request, string $id)
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
     * Get controller route model binding.
     *
     * @param string $comment
     * @param string $request
     * @param string $name
     * @param string $lowerName
     * @return string
     */
    public static function getControllerRouteModelBinding(string $comment, string $request, string $name, string $lowerName)
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