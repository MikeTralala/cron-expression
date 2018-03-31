<?php


$finder = PhpCsFixer\Finder::create()
                           ->in(__DIR__ . '/src');

return PhpCsFixer\Config::create()
                        ->setUsingCache(false)
                        ->setRules([
                            '@PSR2'                             => true,
                            '@Symfony'                          => true,
                            'align_multiline_comment'           => true,
                            'concat_space'                      => ['spacing' => 'one'],
                            'not_operator_with_successor_space' => true,
                            'ordered_class_elements'            => true,
                            'array_indentation'                 => true,
                            'array_syntax'                      => ['syntax' => 'short'],
                            'binary_operator_spaces'            => [
                                'default' => 'align',
                            ],
                        ])
                        ->setFinder($finder);
