<?php

namespace Milwad\LaravelCrod\Tests\Commands\Modules;

use Illuminate\Support\Facades\File;
use Milwad\LaravelCrod\Tests\TestCase;

class MakeCrudModuleCommandTest extends TestCase
{
    /**
     * Test crud files created successfully.
     */
    public function test_crud_files_created_successfully(): void
    {
        $this->artisan('crud:make-module', ['module_name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated for module Product');

        $this->ensureCrudFileCreated();
    }

    /**
     * Test crud files created successfully with seeder.
     */
    public function test_files_created_successfully_with_seeder(): void
    {
        $this->artisan('crud:make-module', ['module_name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 1)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated for module Product');

        $this->ensureCrudFileCreated();

        // Ensure seeder exists
        $this->assertFileExists(base_path('Modules/Product/Database/Seeders/ProductSeeder.php'));
    }

    /**
     * Test crud files created successfully with factory.
     */
    public function test_crud_files_created_successfully_with_factory(): void
    {
        $this->artisan('crud:make-module', ['module_name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 2)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated for module Product');

        $this->ensureCrudFileCreated();

        // Ensure factory exists
        $this->assertFileExists(base_path('Modules/Product/Database/Factories/ProductFactory.php'));
    }

    /**
     * Test crud files created successfully with repository.
     */
    public function test_crud_files_created_successfully_with_repository(): void
    {
        $this->artisan('crud:make-module', ['module_name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 3)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated for module Product');

        $this->ensureCrudFileCreated();

        // Ensure repository exists
        $this->assertFileExists(base_path('Modules/Product/Repositories/ProductRepository.php'));
    }

    /**
     * Test crud files created successfully with service.
     */
    public function test_crud_files_created_successfully_with_service(): void
    {
        $this->artisan('crud:make-module', ['module_name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 4)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated for module Product');

        $this->ensureCrudFileCreated();

        // Ensure service exists
        $this->assertFileExists(base_path('Modules/Product/Services/ProductService.php'));
    }

    /**
     * Test crud files created successfully with tests.
     */
    public function test_crud_files_created_successfully_with_tests(): void
    {
        $this->artisan('crud:make-module', ['module_name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 5)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated for module Product');

        $this->ensureCrudFileCreated();

        // Ensure tests exists
        $this->assertFileExists(base_path('Modules/Product/Tests/Feature/ProductTest.php'));
        $this->assertFileExists(base_path('Modules/Product/Tests/Unit/ProductTest.php'));
    }

    /**
     * Ensure the crud files successfully created.
     */
    protected function ensureCrudFileCreated(): void
    {
        // Ensure model exists
        $this->assertFileExists(base_path('Modules/Product/Entities/Product.php'));

        // Ensure migration exists
        $this->migrationExists('create_products_table');

        // Ensure controller exists
        $this->assertFileExists(base_path('Modules/Product/Http/Controllers/ProductController.php'));

        // Ensure requests exists
        $this->assertFileExists(base_path('Modules/Product/Http/Requests/ProductStoreRequest.php'));
        $this->assertFileExists(base_path('Modules/Product/Http/Requests/ProductUpdateRequest.php'));

        // Ensure views exists
        $this->assertFileExists(base_path('Modules/Product/Resources/Views/index.blade.php'));
        $this->assertFileExists(base_path('Modules/Product/Resources/Views/create.blade.php'));
        $this->assertFileExists(base_path('Modules/Product/Resources/Views/edit.blade.php'));

        // Ensure provide exists
        $this->assertFileExists(base_path('Modules/Product/Providers/ProductServiceProvider.php'));

        // Ensure route exists
        $this->assertFileExists(base_path('Modules/Product/Routes/web.php'));
    }

    /**
     * Check migration file exists.
     */
    protected function migrationExists(string $mgr, string $path = 'Modules/Product/Database/Migrations/'): bool
    {
        $path = base_path($path);
        $files = scandir($path);

        foreach ($files as &$value) {
            $pos = strpos($value, $mgr);
            if ($pos !== false) {
                return true;
            }
        }

        return false;
    }
}
