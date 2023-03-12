<?php

namespace Milwad\LaravelCrod\Datas;

class OptionData
{
    public const SEEDER_OPTION = 'Seeder';
    public const FACTORY_OPTION = 'Factory';
    public const REPOSITORY_OPTION = 'Repository';
    public const SERVICE_OPTION = 'Service';
    public const TEST_OPTION = 'Tests';
    public const EXIT_OPTION = 'exit';

    public static array $options = [
        self::SEEDER_OPTION,
        self::FACTORY_OPTION,
        self::REPOSITORY_OPTION,
        self::SERVICE_OPTION,
        self::TEST_OPTION,
        self::EXIT_OPTION,
    ];
}