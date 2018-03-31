<?php


$finder = PhpCsFixer\Finder::create()
                           ->in(__DIR__ . '/src');

return PhpCsFixer\Config::create()
                        ->setUsingCache(false)
                        ->setRules([
                            '@PSR2'                   => true,
                            '@Symfony'                => true,
                            'align_multiline_comment' => true,
                            'array_indentation'       => true,
                            'array_syntax'            => ['syntax' => 'short'],
                            'binary_operator_spaces'  => [
                                'default' => 'align'
                            ],
                        ])
                        ->setFinder($finder);
