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

        $dateTime = new DateTime();
        $dateTimeImmutable = new DateTimeImmutable();
    }
}
