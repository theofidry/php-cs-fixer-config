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
            1,
            2,
            3
        );
        foo(function ($a) use ($b) {
            return $a + $b;
        });
        echo \PHP_VERSION_ID;
        $defined = \defined('FOO');
        $dateTime = new \DateTime();
        $dateTimeImmutable = new \DateTimeImmutable();
        $a = (unset) $b;
        $foo = 0123;
    }
}
