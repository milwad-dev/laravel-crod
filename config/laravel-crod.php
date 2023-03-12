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
     * Get main controller.
     *
     * This is a namespace of main controller that default path is `App\Http\Controllers\Controller`.
     */
    'main_controller' => 'App\Http\Controllers\Controller',

    /*
     * Modules config.
     *
     * You can make custom modules with special folders ... .
     */
    'modules' => [
        'module_namespace' => 'Modules', // This value is for the name of the folder that the modules are in.
        'model_path' => 'Entities', // This value is for the name of the folder that contains the module models.
        'migration_path' => 'Database\Migrations', // This value is for the name of the folder that contains the module migrations.
        'controller_path' => 'Http\Controllers', // This value is for the name of the folder that contains the module controllers.
        'request_path' => 'Http\Requests', // This value is for the name of the folder that contains the module requests-form.
        'view_path' => 'Resources\Views', // This value is for the name of the folder that contains the module views.
        'service_path' => 'Services', // This value is for the name of the folder that contains the module services.
        'repository_path' => 'Repositories', // This value is for the name of the folder that contains the module Repositories.
        'feature_test_path' => 'Tests\Feature', // This value is for the name of the folder that contains the module feature-tests.
        'unit_test_path' => 'Tests\Unit', // This value is for the name of the folder that contains the module unit-tests.
        'provider_path' => 'Providers', // This value is for the name of the folder that contains the module providers.
        'factory_path' => 'Database\Factories', // This value is for the name of the folder that contains the module factories.
        'seeder_path' => 'Database\Seeders', // This value is for the name of the folder that contains the module seeders.
    ],

    /*
     * Queries.
     *
     * This is some config for add queries.
     */
    'queries' => [
        /*
         * Except columns in fillable.
         *
         * This `except_columns_in_fillable` must be arrayed!
         * This `except_columns_in_fillable` that remove field from $fillable in model.
         */
        'except_columns_in_fillable' => [
            'id', 'updated_at', 'created_at',
        ],
    ],
];
