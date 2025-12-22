<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('docs')
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Pre defined rule sets https://cs.symfony.com/doc/ruleSets/index.html
        '@auto:risky' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile('var/php-cs-fixer/.php-cs-fixer.cache');
