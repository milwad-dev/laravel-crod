<?php

namespace Milwad\LaravelCrod\Traits;

use Milwad\LaravelCrod\Datas\QueryData;

trait AddDataToServiceTrait
{
    /**
     * Add data to service.
     *
     * @param string $model
     * @param string $filename
     * @return void
     */
    private function addDataToService(string $model, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 6);
        $lines[$line_i_am_looking_for] = QueryData::getServiceData($model, '$request', '$id');

        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToService($model, $filename);
    }

    /**
     * Add use to Service for module.
     *
     * @param string $model
     * @param string $filename
     * @return void
     */
    private function addUseToService(string $model, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 3);
        $lines[$line_i_am_looking_for] = "
use $this->module_name_space\\$model\Entities\\$model;
";
        file_put_contents($filename, implode("\n", $lines));
    }
}