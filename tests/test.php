<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

echo \MikeTralala\CronExpression\Timing::create()->getExpression();
echo PHP_EOL;
