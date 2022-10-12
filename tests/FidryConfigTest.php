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

    /**
     * @dataProvider minPhpVersion
     *
     * @param list<string> $expectedRules
     * @param list<string> $expectedIgnoredRules
     */
    public function test_it_applies_rules_supported_by_the_min_php_version(
        int $minPhpVersion,
        array $expectedRules,
        array $expectedIgnoredRules
    ): void {
        $config = new FidryConfig('', $minPhpVersion);

        $rules = $config->getRules();

        foreach ($expectedRules as $expectedRule) {
            self::assertArrayHasKey($expectedRule, $rules);
        }

        foreach ($expectedIgnoredRules as $ignoredRule) {
            self::assertArrayNotHasKey($ignoredRule, $rules);
        }
    }

    public static function minPhpVersion(): iterable
    {
        $php74Rule = '@PHP70Migration';
        $php80Rule = '@PHP80Migration';
        $php81Rule = '@PHP81Migration';

        yield [
            74000,
            [$php74Rule],
            [$php80Rule, $php81Rule],
        ];

        yield [
            80000,
            [$php74Rule, $php80Rule],
            [$php81Rule],
        ];

        yield [
            81000,
            [$php74Rule, $php80Rule, $php81Rule],
            [],
        ];
    }
}
