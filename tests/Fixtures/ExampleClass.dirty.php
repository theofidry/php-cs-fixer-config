<?php

namespace Fidry\PhpCsFixerConfig\Tests\Fixtures;

class ExampleClass
{
    private $foo = true;

    /**
     * @var string
     */
    private $bar = null;

    public function __construct()
    {
        $array = array(
            1,2,3,
        );

        echo \PHP_VERSION_ID;
        $defined = \defined('FOO');
        $dateTime = new \DateTime();
        $dateTimeImmutable = new \DateTimeImmutable();
    }
}
