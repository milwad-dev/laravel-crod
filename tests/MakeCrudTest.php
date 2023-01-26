<?php

namespace Milwad\LaravelCrod\Tests;

class MakeCrudTest extends BaseTest
{
    /**
     * @var string
     */
    private string $name = 'Product';

    /**
     * Test check all files create when user run command 'crud:make'.
     *
     * @test
     * @return void
     */
    public function check_to_create_files_with_command_crud_make()
    {
        $this->artisan("crud:make Product");

        $this->checkAllToModelIsCreatedWithOriginalName();
    }

    /**
     * @return void
     */
    public function checkAllToModelIsCreatedWithOriginalName(): void
    {
        $filename = app_path("Models\\$this->name.php");

        $this->assertEquals(1, file_exists($filename));
        $this->assertEquals($this->name, basename($filename, '.php'));
    }
}