<?php

namespace Milwad\LaravelCrod\Tests;

use Milwad\LaravelCrod\Datas\OptionData;
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
        $this->checkAllToViewIsCreatedWithOriginalName();
    }

    /**
     * Test check all files create when user run command 'crud:make' with options.
     *
     * @test
     *
     * @return void
     */
    public function check_to_create_files_with_command_crud_make_with_options()
    {
        $this->artisan($this->command, ['name' => $this->name])
            ->expectsQuestion($this->question, 0)
            ->expectsOutputToContain('created successfully');

        $this->checkAllToModelIsCreatedWithOriginalName();
        $this->checkAllToMigrationIsCreatedWithOriginalName();
        $this->checkAllToControllerIsCreatedWithOriginalName();
        $this->checkAllToRequestIsCreatedWithOriginalName();
        $this->checkAllToViewIsCreatedWithOriginalName();
        $this->checkAllToServiceIsCreatedWithOriginalName();
        $this->checkAllToRepositoryIsCreatedWithOriginalName();
        $this->checkAllToTestsIsCreatedWithOriginalName();
        $this->checkAllToSeederIsCreatedWithOriginalName();
    }

//    /**
//     * Test check all files create when user run command 'crud:make' with ies name.
//     *
//     * @test
//     *
//     * @return void
//     */
//    public function check_to_create_files_with_command_crud_make_with_ies_name()
//    {
//        $this->name = 'Category';
//        $this->artisan($this->command, ['name' => $this->name])
//            ->expectsQuestion($this->question, 5);
//
//        $this->checkAllToModelIsCreatedWithOriginalName();
//        $this->checkAllToMigrationIsCreatedWithOriginalName();
//        $this->checkAllToControllerIsCreatedWithOriginalName();
//        $this->checkAllToRequestIsCreatedWithOriginalName();
//        $this->checkAllToViewIsCreatedWithOriginalName();
//    }
//
//    /**
//     * Test check all files create when user run command 'crud:make' with ies name with options.
//     *
//     * @test
//     *
//     * @return void
//     */
//    public function check_to_create_files_with_command_crud_make_with_ies_name_with_options()
//    {
//        $this->name = 'Category';
//        $this->artisan($this->command, ['name' => $this->name])
//            ->expectsQuestion($this->question, 0)
//            ->expectsQuestion($this->question, 1)
//            ->expectsQuestion($this->question, 2)
//            ->expectsQuestion($this->question, 3)
//            ->expectsQuestion($this->question, 4)
//            ->expectsQuestion($this->question, 5);
//
//        $this->checkAllToModelIsCreatedWithOriginalName();
//        $this->checkAllToMigrationIsCreatedWithOriginalName();
//        $this->checkAllToControllerIsCreatedWithOriginalName();
//        $this->checkAllToRequestIsCreatedWithOriginalName();
//        $this->checkAllToViewIsCreatedWithOriginalName();
//    }
}
