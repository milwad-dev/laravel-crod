<?php

namespace Milwad\LaravelCrod\Traits;

use Milwad\LaravelCrod\Datas\QueryData;

trait AddDataToRepoTrait
{
    /**
     * Add data to repository.
     *
     *
     * @return void
     */
    private function addDataToRepo(string $model, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 6);
        $lines[$line_i_am_looking_for] = QueryData::getRepoData($model, '$id');

        file_put_contents($filename, implode("\n", $lines));
        $this->addUseToRepo($model, $filename);
    }

    /**
     * Add use to repository.
     *
     *
     * @return void
     */
    private function addUseToRepo(string $model, string $filename)
    {
        [$line_i_am_looking_for, $lines] = $this->lookingLinesWithIgnoreLines($filename, 3);
        $lines[$line_i_am_looking_for] = QueryData::getUseRepoData($model);

        file_put_contents($filename, implode("\n", $lines));
    }
}
