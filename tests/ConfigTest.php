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

use PhpCsFixer\Config;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

use function file_get_contents;
use function str_replace;

/**
 * @covers \Fidry\PhpCsFixerConfig\Config
 *
 * @internal
 */
class ConfigTest extends TestCase
{
    private const FIXTURES_DIR = __DIR__.'/Fixtures';

    private Filesystem $filesystem;

    private string $tmpDir;

    protected function setUp(): void
    {
        $this->filesystem = new Filesystem();

        $this->tmpDir = TmpDirectoryGenerator::generate(
            $this->filesystem,
            str_replace('\\', '_', __CLASS__)
        );
    }

    protected function tearDown(): void
    {
        $this->filesystem->remove($this->tmpDir);
    }

    public function test_it_can_be_instantiated(): void
    {
        $config = new Config(
            <<<'EOF'
            This file is part of the Fidry PHP-CS-Fixer Config package.

            (c) Théo FIDRY <theo.fidry@gmail.com>

            For the full copyright and license information, please view the LICENSE
            file that was distributed with this source code.
            EOF,
        );

        self::assertInstanceOf(Config::class, $config);
    }

    public function test_it_can_be_used_to_fix_code(): void
    {
        $tmpFile = $this->tmpDir.'/example.php';

        $this->filesystem->copy(
            self::FIXTURES_DIR.'/example-dirty.php',
            $tmpFile,
        );

        $config = new Config(
            <<<'EOF'
                This file is part of the Fidry PHP-CS-Fixer Config package.

                (c) Théo FIDRY <theo.fidry@gmail.com>

                For the full copyright and license information, please view the LICENSE
                file that was distributed with this source code.
                EOF,
        );

        $config->setRiskyAllowed(true);

        CSFixerFacade::fixFiles($config, $this->tmpDir);

        self::assertFileEquals(
            self::FIXTURES_DIR.'/example-fixed.php',
            $tmpFile,
            file_get_contents($tmpFile),
        );
    }
}
