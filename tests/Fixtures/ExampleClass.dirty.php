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

        $dateTime = new \DateTime();
        $dateTimeImmutable = new \DateTimeImmutable();
    }
}
