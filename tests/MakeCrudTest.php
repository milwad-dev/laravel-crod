<?php

namespace Milwad\LaravelCrod\Tests;

use Milwad\LaravelCrod\Tests\Traits\MakeCrudTestTrait;

class MakeCrudTest extends BaseTest
{
    use MakeCrudTestTrait;

    private string $name = 'Product';
    private string $question = 'You want something extra?';
    private string $command = 'crud:make';

    /**
     * Test check all files create when user run command 'crud:make'.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make()
    {
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 5);

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName($this->name);
    }

    /**
     * Test check all files create when user run command 'crud:make' with option seeder.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_option_seeder()
    {
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 0)
            ->expectsOutputToContain('created successfully');

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName($this->name);
        $this->checkAllToServiceIsCreatedWithOriginalName();
        $this->checkAllToRepositoryIsCreatedWithOriginalName();
        $this->checkAllToTestsIsCreatedWithOriginalName();
        $this->checkAllToSeederIsCreatedWithOriginalName();
    }

    /**
     * Test check all files create when user run command 'crud:make' with option service.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_option_service()
    {
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 3)
            ->expectsOutputToContain('created successfully');

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName($this->name);
        $this->checkAllToServiceIsCreatedWithOriginalName();
    }

    /**
     * Test check all files create when user run command 'crud:make' with option repository.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_option_repository()
    {
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 3)
            ->expectsOutputToContain('created successfully');

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName($this->name);
        $this->checkAllToRepositoryIsCreatedWithOriginalName();
    }

    /**
     * Test check all files create when user run command 'crud:make' with ies name.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_ies_name()
    {
        $this->name = 'Category';
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 5);

        $this->checkAllToModelIsCreatedWithOriginalName();
//        $this->checkAllToMigrationIsCreatedWithOriginalName(); TODO: Fixed
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName('Category');
    }

    /**
     * Test check all files create when user run command 'crud:make' with ies name with options.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_ies_name_with_options()
    {
        $this->name = 'Category';
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 0)
            ->expectsOutputToContain('created successfully');

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
//        $this->checkAllToSeederIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName('Category');
        $this->checkAllToMigrationIsCreatedWithOriginalName();
    }
}
