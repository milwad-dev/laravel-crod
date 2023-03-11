<?php

namespace Milwad\LaravelCrod\Services;

class LaravelCrodService
{
    /**
     * Get current name with check latest letter ex (category => categories - product => products).
     *
     *
     * @return string
     */
    public function getCurrentNameWithCheckLatestLetter(string $name, bool $needToLower = true)
    {
        if (str_ends_with($name, 'y')) {
            $name = substr_replace($name, '', -1);
            $name .= 'ies';
        } else {
            $name = substr_replace($name, '', -1);
            $name .= 's';
        }

        return $needToLower
            ? strtolower($name)
            : $name;
    }

    /**
     * Change backslash to slash.
     *
     *
     * @return string
     */
    public function changeBackSlashToSlash(string $str)
    {
        return str_replace('\\', '/', $str);
    }
}
