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
use function array_filter;
use function array_merge;
use const ARRAY_FILTER_USE_BOTH;

final class FidryConfig extends BaseConfig
{
    private const UNIVERSAL_RULES = [
        '@DoctrineAnnotation' => true,

        '@PHP70Migration' => true,
        '@PHP70Migration:risky' => true,
        '@PHP73Migration' => true,

        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,

        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,

        '@Symfony' => true,
        '@Symfony:risky' => true,

        'align_multiline_comment' => true,
        'array_indentation' => true,
        'backtick_to_shell_exec' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'continue',
                'declare',
                'return',
                'throw',
                'try',
            ],
        ],
        'blank_line_between_import_groups' => false,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'combine_nested_dirname' => true,
        'compact_nullable_typehint' => true,
        'declare_strict_types' => true,
        'dir_constant' => true,
        'echo_tag_syntax' => [
            'format' => 'short',
        ],
        'ereg_to_preg' => true,
        // Don't mark internal classes as final
        // PHPUnit tests are marked as internal automatically. This
        // step would automatically make them final, which breaks
        // inheritance.
        'final_internal_class' => false,
        'fopen_flag_order' => true,
        'fopen_flags' => true,
        'fully_qualified_strict_types' => true,
        'general_phpdoc_annotation_remove' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'heredoc_indentation' => true,
        'heredoc_to_nowdoc' => true,
        'is_null' => true,
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'logical_operators' => true,
        'mb_str_functions' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'modernize_types_casting' => true,
        'multiline_comment_opening_closing' => true,
        // Keep semicolons on the last line of multiline statements
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'native_constant_invocation' => false,
        'native_function_invocation' => false,
        'no_alternative_syntax' => true,
        'no_binary_string' => true,
        'no_homoglyph_names' => true,
        'no_php4_constructor' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_singleline' => [
            'elements' => [
                'arguments',
                'array_destructuring',
                'array',
                'group_import',
            ],
        ],
        'no_unset_cast' => true,
        'no_unset_on_property' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_superfluous_phpdoc_tags' => [
            'remove_inheritdoc' => true,
            // Required for Psalm
            'allow_mixed' => true,
        ],
        'nullable_type_declaration_for_default_null_value' => true,
        'ordered_class_elements' => false,
        // Order class, constant and function imports correctly
        // Required because we added "global_namespace_import"
        'ordered_imports' => [
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
        ],
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_order' => true,
        'phpdoc_order_by_value' => true,
        'phpdoc_separation' => false,
        'phpdoc_to_comment' => false,
        // Don't add "meta" here in order not to rename classes called
        // "Resource" to "resource"
        'phpdoc_types' => [
            'groups' => [
                'simple',
                'alias',
            ],
        ],
        'phpdoc_types_order' => false,
        'phpdoc_var_annotation_correct_order' => true,
        'php_unit_construct' => true,
        'php_unit_method_casing' => [
            'case' => 'snake_case',
        ],
        'php_unit_set_up_tear_down_visibility' => true,
        // Don't replace assertEquals() by assertSame()
        'php_unit_strict' => false,
        'php_unit_test_class_requires_covers' => false,
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'self',
        ],
        'pow_to_exponentiation' => true,
        'protected_to_private' => true,
        'self_static_accessor' => true,
        'single_line_throw' => false,
        'single_trait_insert_per_statement' => false,
        // Don't replace == by === as we use it to compare value objects
        'strict_comparison' => false,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => [
                'arrays',
                'arguments',
            ],
        ],
    ];

    private const PHP_VERSION_SPECIFIC_RULES = [
        80000 => [
            '@PHP80Migration' => true,
            '@PHP80Migration:risky' => true,
        ],
        81000 => [
            '@PHP81Migration' => true,

            'no_superfluous_phpdoc_tags' => [
                'remove_inheritdoc' => true,
                // Required for Psalm in <PHP8.1
                'allow_mixed' => false,
            ],
            'trailing_comma_in_multiline' => [
                'after_heredoc' => true,
                'elements' => [
                    'arrays',
                    'arguments',
                    'parameters',
                ],
            ],
        ],
    ];

    public function __construct(?string $headerComment, int $phpMinVersion)
    {
        parent::__construct();

        $phpSpecificRules = array_filter(
            self::PHP_VERSION_SPECIFIC_RULES,
            static fn (array $rules, int $requiredPhpVersion): bool => $requiredPhpVersion <= $phpMinVersion,
            ARRAY_FILTER_USE_BOTH,
        );

        $headerRule = null === $headerComment
            ? []
            : [
                'header_comment' => [
                    'header' => $headerComment,
                    'location' => 'after_open',
                ],
            ];

        $rules = array_merge(
            self::UNIVERSAL_RULES,
            $headerRule,
            ...$phpSpecificRules,
        );

        $this
            ->setRules($rules)
            ->setRiskyAllowed(true);
    }

    public function addRules(array $rules): self
    {
        $this->setRules(
            array_merge(
                $this->getRules(),
                $rules,
            ),
        );

        return $this;
    }
}
