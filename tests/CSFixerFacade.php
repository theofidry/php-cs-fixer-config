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

use PhpCsFixer\Cache\NullCacheManager;
use PhpCsFixer\Config;
use PhpCsFixer\Console\ConfigurationResolver;
use PhpCsFixer\Error\ErrorsManager;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Runner;
use PhpCsFixer\ToolInfo;

final class CSFixerFacade
{
    private function __construct()
    {
    }

    public static function fixFiles(Config $config, string $path): void
    {
        $toolInfo = new ToolInfo();
        $errorsManager = new ErrorsManager();

        $resolver = new ConfigurationResolver(
            $config,
            [
                'dry-run' => false,
                'stop-on-violation' => false,
            ],
            $path,
            $toolInfo
        );

        $finder = Finder::create()->in($path);

        $runner = new Runner(
            $finder,
            $resolver->getFixers(),
            $resolver->getDiffer(),
            null,
            $errorsManager,
            $resolver->getLinter(),
            $resolver->isDryRun(),
            new NullCacheManager(),
            $resolver->getDirectory(),
            $resolver->shouldStopOnViolation()
        );

        $runner->fix();
    }
}
