<?php

namespace Milwad\LaravelCrod\Traits;

use Milwad\LaravelCrod\Datas\QueryData;

trait AddDataToServiceTrait
{
    /**
     * Add data to service.
     *
     *
     * @return void
     */
    private function addDataToService(string $model, string $filename, string $uses)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 6);
        $lines[$line_i_am_looking_for] = QueryData::getServiceData($model, '$request', '$id');

        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToService($uses, $filename);
    }

    /**
     * Add use to Service for module.
     *
     *
     * @return void
     */
    private function addUseToService(string $uses, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 3);
        $lines[$line_i_am_looking_for] = $uses;

        file_put_contents($filename, implode("\n", $lines));
    }
}
