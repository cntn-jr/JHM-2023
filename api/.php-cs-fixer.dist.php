<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'for', 'foreach', 'if', 'switch', 'try'
            ],
        ],
        'global_namespace_import' => true,
        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => false
        ],
        'yoda_style' => [
            'always_move_variable' => false,
            'equal' => false,
            'identical' => false
        ],
    ])
    ->setFinder($finder);