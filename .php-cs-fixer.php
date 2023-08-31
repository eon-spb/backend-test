<?php

$finder = PhpCsFixer\Finder::create()->exclude('storage')->in(__DIR__.'/src');

$config = new PhpCsFixer\Config();
return $config->setRules(
    [
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHP80Migration:risky' => true,
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
    ]
)->setFinder($finder);
