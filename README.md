PHP Cron Expression Parser
==========================

[![pipeline status](https://gitlab.miketralala.com/tralala/cron-expression/badges/master/pipeline.svg)](https://gitlab.miketralala.com/tralala/cron-expression/commits/master)
[![coverage report](https://gitlab.miketralala.com/tralala/cron-expression/badges/master/coverage.svg)](https://gitlab.miketralala.com/tralala/cron-expression/commits/master)

This `cron-expression` library can parse cron expressions like `* * * * *` and check if 
it is due or not. You are also able to determine the next or previous running dates.

This parser can handle anything the normal cron syntax accepts. with 1 exception and that
are the named constructs (e.g. mon-thu or jan-dec). 

Installing
==========

Add the dependency to your project:

```bash
composer require mike-tralala/cron-expression
```

Usage
=====
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use MikeTralala\CronExpression\Expression\DueDateCalculator;
use MikeTralala\CronExpression\Expression\Expression;

// Works with predefined definitions
$expression = new Expression(Expression::WEEKLY);
$expression->isDue();

$expression = new Expression(Expression::MINUTELY);
$expression->isDue();

// Works with complex definitions
$expression = new Expression('10-40/10 0 */5 1 4,5');
$expression->isDue();

// Calculating next running date
$calculator = new DueDateCalculator();
$expression = new Expression('*/2 * * * *');

$dueDates = $calculator->getNextDueDates($expression, 5, \DateTime::createFromFormat('Y-m-d H:i', '2018-01-01 00:00'));

echo $expression . PHP_EOL;
foreach ($dueDates as $dueDate) {
    echo $dueDate->format('Y-m-d H:i') . PHP_EOL;
}

// Output:
 
// */2 * * * *
// 2018-01-01 00:00
// 2018-01-01 00:02
// 2018-01-01 00:04
// 2018-01-01 00:06
// 2018-01-01 00:08
```

CRON Expressions
================

A CRON expression is a string representing the schedule for a particular command to execute.  The parts of a CRON schedule are as follows:

    *    *    *    *    *
    -    -    -    -    -
    |    |    |    |    |
    |    |    |    |    |
    |    |    |    |    +----- day of week (0 - 6) (Sunday=0)
    |    |    |    +---------- month (1 - 12)
    |    |    +--------------- day of month (1 - 31)
    |    +-------------------- hour (0 - 23)
    +------------------------- min (0 - 59)

Requirements
============

- PHP 5.5+
- PHPUnit is required to run the unit tests
- Composer is required to run the unit tests
