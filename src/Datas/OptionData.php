<?php

namespace Milwad\LaravelCrod\Datas;

class OptionData
{
    public const SEEDER_OPTION = 'seeder';
    public const FACTORY_OPTION = 'factory';

    public static array $options = [
        self::SEEDER_OPTION,
        self::FACTORY_OPTION,
    ];
}