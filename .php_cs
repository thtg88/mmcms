<?php

$finder = PhpCsFixer\Finder::create()
    ->name('*.stub')
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setFinder($finder);
