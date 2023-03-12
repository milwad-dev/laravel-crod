<?php

namespace Milwad\LaravelCrod\Datas;

/*
 * This file is for add data in crud files.
 *
 * ======================== WARNING ======================== => DO NOT MAKE ANY CHANGES TO THIS FILE
 */

use Milwad\LaravelCrod\Facades\LaravelCrodServiceFacade;

class QueryData
{
    /**
     * Get model data.
     *
     *
     * @return string
     */
    public static function getModelData(mixed $items)
    {
        return PHP_EOL.'    protected $fillable = ['.$items.'];'.PHP_EOL.'}';
    }

    /**
     * Get service data.
     *
     *
     * @return string
     */
    public static function getServiceData(string $model, string $request, string $id)
    {
        return "    public function store($request)
    {
        return $model::query()->create(".'$request->all()'.");
    }

    public function update($request, $id)
    {
        return $model::query()->where('id', $id)->update(".'$request->all()'.');
    }';
    }

    /**
     * Get use for service.
     *
     *
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
     *
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
     *
     * @return string
     */
    public static function getUseRepoData(string $model, bool $isModule)
    {
        if ($isModule) {
            $modulePath = config('laravel-crod.modules.module_namespace', 'Modules');
            $modelPath = config('laravel-crod.modules.model_path', 'Entities');

            return "use $modulePath\\$model\\$modelPath\\$model; \n";
        }

        return "use App\Models\\$model;";
    }

    /**
     * Get controller-id data.
     *
     *
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
    
    public function show($id)
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
     *
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
    
    public function show($name $$lowerName)
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
     * Get data for provider.
     *
     *
     * @return string
     */
    public static function getProviderData(string $moduleName)
    {
        $modulePaths = config('laravel-crod.modules', []);
        $migrationPath = '/../'.LaravelCrodServiceFacade::changeBackSlashToSlash($modulePaths['migration_path']);
        $viewPath = '/../'.LaravelCrodServiceFacade::changeBackSlashToSlash($modulePaths['view_path']);

        return "        \$this->loadMigrationsFrom(__DIR__ . '$migrationPath');
        \$this->loadViewsFrom(__DIR__ . '$viewPath', '$moduleName');";
    }
}
