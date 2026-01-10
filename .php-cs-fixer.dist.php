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

use Fidry\PhpCsFixerConfig\FidryConfig;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'tests/Fixtures',
        'vendor',
    ])
    ->ignoreDotFiles(false);

$config = new FidryConfig(
    <<<'EOF'
        This file is part of the Fidry PHP-CS-Fixer Config package.

        (c) Théo FIDRY <theo.fidry@gmail.com>

        For the full copyright and license information, please view the LICENSE
        file that was distributed with this source code.
        EOF,
    82_000,
);

return $config
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/var/php-cs-fixer.cache')
    ->setUnsupportedPhpVersionAllowed(true);
