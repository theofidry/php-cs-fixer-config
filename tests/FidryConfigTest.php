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

use Fidry\PhpCsFixerConfig\FidryConfig;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use function file_get_contents;
use function str_replace;

/**
 * @covers \Fidry\PhpCsFixerConfig\FidryConfig
 *
 * @internal
 */
class FidryConfigTest extends TestCase
{
    private const FIXTURES_DIR = __DIR__.'/Fixtures';

    private Filesystem $filesystem;

    private string $tmpDir;

    protected function setUp(): void
    {
        $this->filesystem = new Filesystem();

        $this->tmpDir = TmpDirectoryGenerator::generate(
            $this->filesystem,
            str_replace('\\', '_', __CLASS__),
        );
    }

    protected function tearDown(): void
    {
        $this->filesystem->remove($this->tmpDir);
    }

    public function test_it_can_be_instantiated(): void
    {
        $config = new FidryConfig(
            <<<'EOF'
                This file is part of the Fidry PHP-CS-Fixer Config package.

                (c) Théo FIDRY <theo.fidry@gmail.com>

                For the full copyright and license information, please view the LICENSE
                file that was distributed with this source code.
                EOF,
            74_000,
        );

        self::assertInstanceOf(FidryConfig::class, $config);
    }

    public function test_it_can_be_used_to_fix_code(): void
    {
        $tmpFile = $this->tmpDir.'/ExampleClass.php';

        $this->filesystem->copy(
            self::FIXTURES_DIR.'/ExampleClass.dirty.php',
            $tmpFile,
        );

        $config = new FidryConfig(
            <<<'EOF'
                This file is part of the Fidry PHP-CS-Fixer Config package.

                (c) Théo FIDRY <theo.fidry@gmail.com>

                For the full copyright and license information, please view the LICENSE
                file that was distributed with this source code.
                EOF,
            74_000,
        );
        $config->setRiskyAllowed(true);

        CSFixerFacade::fixFiles($config, $this->tmpDir);

        self::assertFileEquals(
            self::FIXTURES_DIR.'/ExampleClass.fixed.php',
            $tmpFile,
            file_get_contents($tmpFile),
        );
    }
}
