<?php

return [
    /**
     * Module namespace
     */
    'module_namespace' => 'Modules',

    /**
     * Modules config.
     */
    'modules' => [
        'model_path' => 'Entities',
        'migration_path' => 'Database/Migrations',
        'controller_path' => 'Http\Controllers',
        'request_path' => 'Http\Requests',
        'view_path' => 'Resources\Views',
        'service_path' => 'Services',
        'repository_path' => 'Repositories',
        'feature_test_path' => 'Tests\Feature',
        'unit_test_path' => 'Tests\Unit',
    ],
];
