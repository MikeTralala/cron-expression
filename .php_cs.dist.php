<?php


$finder = PhpCsFixer\Finder::create()
                           ->in(__DIR__ . '/src');

return PhpCsFixer\Config::create()
                        ->setUsingCache(false)
                        ->setRules([
                            '@PSR2'            => true,
                            '@Symfony'         => true,
//                            'mb_str_functions' => true,
                        ])
                        ->setFinder($finder);
