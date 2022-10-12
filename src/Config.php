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

namespace Fidry\PhpCsFixerConfig;

use PhpCsFixer\Config as BaseConfig;

final class Config extends BaseConfig
{
    public function __construct(string $headerComment)
    {
        parent::__construct();

        $this
            ->setRules([
                '@PhpCsFixer' => true,
                '@PhpCsFixer:risky' => true,
                '@Symfony' => true,
                '@Symfony:risky' => true,
                '@PHP80Migration' => true,
                '@PHP80Migration:risky' => true,
                '@PHP81Migration' => true,
                '@PHPUnit84Migration:risky' => true,
                '@DoctrineAnnotation' => true,
                'self_static_accessor' => true,
                'global_namespace_import' => [
                    'import_classes' => true,
                    'import_constants' => true,
                    'import_functions' => true,
                ],
                // Order class, constant and function imports correctly
                // Required because we added "global_namespace_import"
                'ordered_imports' => [
                    'imports_order' => [
                        'class',
                        'function',
                        'const',
                    ],
                ],
                'header_comment' => [
                    'header' => $headerComment,
                    'location' => 'after_open',
                ],
                'mb_str_functions' => true,
                'no_superfluous_phpdoc_tags' => [
                    'remove_inheritdoc' => true,
                    // Required for Psalm
                    'allow_mixed' => true,
                ],
                'nullable_type_declaration_for_default_null_value' => true,
                'phpdoc_to_comment' => false,
                'php_unit_method_casing' => [
                    'case' => 'snake_case',
                ],
                'php_unit_test_case_static_method_calls' => [
                    'call_type' => 'self',
                ],
                'single_line_throw' => false,
                'phpdoc_types_order' => false,
                'single_trait_insert_per_statement' => false,
                // Don't replace == by === as we use it to compare value objects
                'strict_comparison' => false,
                // Don't replace assertEquals() by assertSame()
                // We're taking advantage of our StrictPHPUnitExtension which
                // compares scalar values with type safety even for
                // assertEquals()
                'php_unit_strict' => false,
                // Keep semicolons on the last line of multiline statements
                'multiline_whitespace_before_semicolons' => [
                    'strategy' => 'no_multi_line',
                ],
                // Don't mark internal classes as final
                // PHPUnit tests are marked as internal automatically. This
                // step would automatically make them final, which breaks
                // inheritance.
                'final_internal_class' => false,
                // Don't add "meta" here in order not to rename classes called
                // "Resource" to "resource"
                'phpdoc_types' => [
                    'groups' => [
                        'simple',
                        'alias',
                    ],
                ],
            ])
            ->setRiskyAllowed(true);
    }
}
