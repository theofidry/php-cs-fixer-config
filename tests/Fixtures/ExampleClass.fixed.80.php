<?php

/*
 * This file is part of the Fidry PHP-CS-Fixer Config package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Fidry\PhpCsFixerConfig\Tests\Fixtures;

use DateTime;
use DateTimeImmutable;
use function defined;
use const PHP_VERSION_ID;

class ExampleClass
{
    private $foo = true;

    /**
     * @var string
     */
    private $bar;

    public function __construct()
    {
        $array = [
            1, 2, 3,
        ];

        echo PHP_VERSION_ID;
        $defined = defined('FOO');
        $dateTime = new DateTime();
        $dateTimeImmutable = new DateTimeImmutable();
        str_starts_with($haystack, $needle);
        $foo = 0123;
        $name = 'World';
        echo "Hello {$name}!";
    }
}
