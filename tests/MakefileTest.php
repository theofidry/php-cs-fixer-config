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

namespace Fidry\PhpCsFixerConfig\Tests;

use Fidry\Makefile\Test\BaseMakefileTestCase;

/**
 * @coversNothing
 *
 * @internal
 *
 * @requires PHP 8.4
 */
final class MakefileTest extends BaseMakefileTestCase
{
    protected static function getMakefilePath(): string
    {
        return __DIR__.'/../Makefile';
    }

    protected function getExpectedHelpOutput(): string
    {
        return <<<'EOF'
            [33mUsage:[0m
              make TARGET

            [32m#
            # Commands
            #---------------------------------------------------------------------------[0m
            [33mclean:[0m		 Clean temporary files
            [33mcs:[0m		 Runs CS fixers
            [33mcs_lint:[0m	 Runs CS linters
            [33mphpunit:[0m	 Runs PHPUnit

            EOF;
    }
}
