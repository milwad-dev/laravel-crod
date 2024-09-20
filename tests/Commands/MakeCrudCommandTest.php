<?php

namespace Milwad\LaravelCrod\Tests\Commands;

use Milwad\LaravelCrod\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MakeCrudCommandTest extends TestCase
{
    /**
     * Test crud files created successfully.
     */
    #[Test]
    public function crud_files_created_successfully(): void
    {
        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();
    }

    /**
     * Test crud files created successfully with seeder.
     */
    #[Test]
    public function crud_files_created_successfully_with_seeder(): void
    {
        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 1)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();

        $this->assertFileExists(database_path('seeders/ProductSeeder.php'));
    }

    /**
     * Test crud files created successfully with factory.
     */
    #[Test]
    public function crud_files_created_successfully_with_factory(): void
    {
        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 2)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();

        $this->assertFileExists(database_path('factories/ProductFactory.php'));
    }

    /**
     * Test crud files created successfully with repository.
     */
    #[Test]
    public function crud_files_created_successfully_with_repository(): void
    {
        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 3)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();

        $this->assertFileExists(app_path('Repositories/ProductRepo.php'));
    }

    /**
     * Test crud files created successfully with service.
     */
    #[Test]
    public function crud_files_created_successfully_with_service(): void
    {
        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 4)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();

        $this->assertFileExists(app_path('Services/ProductService.php'));
    }

    /**
     * Test crud files created successfully with tests.
     */
    #[Test]
    public function crud_files_created_successfully_with_tests(): void
    {
        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 5)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();

        $this->assertFileExists(base_path('tests/Feature/ProductTest.php'));
        $this->assertFileExists(base_path('tests/Unit/ProductTest.php'));
    }

    /**
     * Test crud files created successfully with tests.
     */
    #[Test]
    public function crud_files_created_successfully_with_tests_using_pest(): void
    {
        config()->set(['laravel-crod.are_using_pest', true]);

        $this->artisan('crud:make', ['name' => 'Product'])
            ->expectsQuestion('Do you want something extra?', 5)
            ->expectsQuestion('Do you want something extra?', 0)
            ->assertSuccessful()
            ->expectsOutput('Crud files successfully generated...');

        $this->ensureCrudFileCreated();

        $this->assertFileExists(base_path('tests/Feature/ProductTest.php'));
        $this->assertFileExists(base_path('tests/Unit/ProductTest.php'));
    }

    /**
     * Ensure the crud files successfully created.
     */
    protected function ensureCrudFileCreated(): void
    {
        // Model
        $this->assertFileExists(app_path('Models/Product.php'));

        // Migration
        $this->migrationExists('create_products_table');

        // Controller
        $this->assertFileExists(app_path('Http/Controllers/ProductController.php'));

        // Requests
        $this->assertFileExists(app_path('Http/Requests/ProductStoreRequest.php'));
        $this->assertFileExists(app_path('Http/Requests/ProductUpdateRequest.php'));

        // View
        $this->assertFileExists(resource_path('views/products/index.blade.php'));
        $this->assertFileExists(resource_path('views/products/create.blade.php'));
        $this->assertFileExists(resource_path('views/products/edit.blade.php'));
    }

    /**
     * Check migration file exists.
     */
    protected function migrationExists(string $mgr): bool
    {
        $path = database_path('migrations/');
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
