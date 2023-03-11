<?php

return [
    /*
     * Repository namespace.
     *
     * This is a word that move into the latest name of repository file, for ex: ProductRepo.
     * If this value is changed, any repos that are created will be renamed, for ex: ProductRepository.
    */
    'repository_namespace' => 'Repo',

    /*
     * Modules config.
     *
     * You can make custom modules with special folders ...
     */
    'modules' => [
        'module_namespace' => 'Modules',
        'model_path' => 'Entities',
        'migration_path' => 'Database\Migrations',
        'controller_path' => 'Http\Controllers',
        'request_path' => 'Http\Requests',
        'view_path' => 'Resources\Views',
        'service_path' => 'Services',
        'repository_path' => 'Repositories',
        'feature_test_path' => 'Tests\Feature',
        'unit_test_path' => 'Tests\Unit',
        'provider_path' => 'Providers',
    ],

    /*
     * Queries.
     */
    'queries' => [
        'except_columns_in_fillable' => [
            'id', 'updated_at', 'created_at'
        ]
    ],

    /*
     * Get main controlelr.
     */
    'main_controller' => 'App\Http\Controllers\Controller'
];
