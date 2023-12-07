<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('docs')
    ->exclude('tools');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Pre defined rule sets https://cs.symfony.com/doc/ruleSets/index.html
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP80Migration:risky' => true,
        '@PHP82Migration' => true,
        // Alias https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#alias
        'mb_str_functions' => true,
        // Basic https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#basic
        'curly_braces_position' => true,
        'no_multiple_statements_per_line' => true,
        // Clas Notation https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#class-notation
        'ordered_interfaces' => true,
        'self_static_accessor' => true,
        'visibility_required' => [
            'elements' => [
                'const',
                'method',
                'property',
            ],
        ],
        // Comment
        'single_line_comment_style' => [
            'comment_types' => [
                'hash',
            ],
        ],
        // Control Structure https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#control-structure
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,
        'simplified_if_return' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => true,
            'elements' => [
                'arguments',
                'arrays',
                'match',
                'parameters',
            ],
        ],
        // Function Notation https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#function-notation
        'date_time_create_from_format_call' => true,
        'fopen_flags' => [
            'b_mode' => true,
        ],
        'nullable_type_declaration_for_default_null_value' => true,
        'regular_callable_call' => true,
        'static_lambda' => true,
        // Import https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#import
        'global_namespace_import' => [
            'import_constants' => true,
            'import_functions' => true,
            'import_classes' => true,
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
        ],
        // Language Construct https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#language-construct
        'declare_parentheses' => true,
        // Operator https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#operator
        'concat_space' => [
            'spacing' => 'one',
        ],
        // PHPUnit https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#phpunit
        'php_unit_dedicate_assert' => [
            'target' => 'newest',
        ],
        'php_unit_dedicate_assert_internal_type' => [
            'target' => 'newest',
        ],
        'php_unit_expectation' => [
            'target' => 'newest',
        ],
        'php_unit_mock' => [
            'target' => 'newest',
        ],
        'php_unit_namespaced' => [
            'target' => 'newest',
        ],
        'php_unit_no_expectation_annotation' => [
            'target' => 'newest',
        ],
        'php_unit_test_class_requires_covers' => false, // https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/issues/6795
        // PHPDoc https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#phpdoc
        'phpdoc_line_span' => true,
        'phpdoc_tag_casing' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
        ],
        // Return Notation https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#return-notation
        'simplified_null_return' => true,
        // Semicolon https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#semicolon
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        // Whitespace https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/blob/master/doc/rules/index.rst#whitespace
        'statement_indentation' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile('.php-cs-fixer.cache');
