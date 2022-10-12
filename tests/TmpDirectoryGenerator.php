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

use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Throwable;
use function bin2hex;
use function random_bytes;
use function sprintf;
use function sys_get_temp_dir;

final class TmpDirectoryGenerator
{
    private const MAX_LOOP_COUNT = 500;

    public static function generate(Filesystem $filesystem, string $namespace): string
    {
        for ($attemptCount = 0; $attemptCount < self::MAX_LOOP_COUNT; ++$attemptCount) {
            $seed = bin2hex(random_bytes(5));
            $tmpDir = sys_get_temp_dir().'/'.$namespace.'_'.$seed;

            try {
                $filesystem->mkdir($tmpDir);

                return $tmpDir;
            } catch (Throwable $throwable) {
                continue;
            }
        }

        throw new RuntimeException(
            sprintf(
                'Could not generate a temporary directory for the namespace "%s" after "%s" attempt.',
                $namespace,
                self::MAX_LOOP_COUNT,
            ),
        );
    }
}
