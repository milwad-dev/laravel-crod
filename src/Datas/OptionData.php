<?php

namespace Milwad\LaravelCrod\Datas;

class OptionData
{
    public const SEEDER_OPTION = 'seeder';
    public const FACTORY_OPTION = 'factory';
    public const EXIT_OPTION = 'exit';

    public static array $options = [
        self::SEEDER_OPTION,
        self::FACTORY_OPTION,
        self::EXIT_OPTION,
    ];
}