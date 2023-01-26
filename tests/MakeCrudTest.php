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

        $this->assertEquals(1, file_exists(app_path("Models\\$this->name.php")));
    }
}