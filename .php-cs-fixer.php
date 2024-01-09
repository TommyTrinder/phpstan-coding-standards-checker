#!/usr/bin/env php
<?php

use PhpCsFixer\Finder;
use PhpCsFixer\Config;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('tests/Rules/Fixtures')
;

return (new Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_imports' => true,
        'phpdoc_align' => false,
        'phpdoc_order' => true,
        'phpdoc_summary' => false,
        'yoda_style' => false,
        'single_line_throw' => false,
        'visibility_required' => false,
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => true],
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setCacheFile('.php_cs.cache');
