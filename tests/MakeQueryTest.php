<?php

namespace Milwad\LaravelCrod\Tests;

class MakeQueryTest extends BaseTest
{
    /**
     * @var string
     */
    private string $command = 'crud:query';

    /**
     * @var string
     */
    private string $model = 'Product';

    /**
     * @var string
     */
    private string $table_name = 'products';

    /**
     * Test when user run 'crud:query' command, add query successfully.
     *
     * @test
     * @return void
     */
    public function when_user_run_crud_query_command_add_query_successfully()
    {
        $this->artisan('crud:make', ['name' => 'Product']);

        $this->artisan($this->command, [
            'model' => $this->model,
            'table_name' => $this->table_name
        ]);
    }
}