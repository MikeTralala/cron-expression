<?php

namespace Tests\MikeTralala\CronExpression\Expression;

use MikeTralala\CronExpression\Expression\DueDateCalculator;
use MikeTralala\CronExpression\Expression\Expression;
use PHPUnit\Framework\TestCase;
use Tests\MikeTralala\Utility\InvokableMethodTrait;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\DueDateCalculator
 */
class DueDateCalculatorTest extends TestCase
{
    use InvokableMethodTrait;

    /**
     * @covers ::getDueDates
     */
    public function test_get_due_dates()
    {
        $calculator = new DueDateCalculator();

        $dueDates = $calculator->getDueDates(DueDateCalculator::TYPE_FUTURE, new Expression('* * * * *'), 5);
        $this->assertTrue(is_array($dueDates));
        $this->assertCount(5, $dueDates);

        $dueDates = $calculator->getDueDates(DueDateCalculator::TYPE_PAST, new Expression('* * * * *'), 5);
        $this->assertTrue(is_array($dueDates));
        $this->assertCount(5, $dueDates);
    }

    /**
     * @coversNothing
     */
    public function test_multiple_expressions()
    {
        $calculator = new DueDateCalculator(10000);

        $expressions = [
            new Expression('* * * * *'),
            new Expression('0 * * * *'),
            new Expression('0 0 * * *'),
            new Expression('1-20 * * * *'),
            new Expression('15 7 1 1 *'),
            new Expression('15/5 0 * * *'),
            new Expression('10 10 * * */2'),
            new Expression('10 10 * 2,1/2 */2'),
            new Expression('10 10 */2 */2 */2'),
            new Expression('3-59/15 0 * * *'),
            new Expression('0 0 */15 1 2-5'),
        ];

        foreach ($expressions as $expression) {
            $dueDates = $calculator->getDueDates(DueDateCalculator::TYPE_FUTURE, $expression, 5);
            $this->assertTrue(is_array($dueDates));
            $this->assertCount(5, $dueDates, $expression);
        }
    }

    /**
     * @covers ::__construct
     * @covers ::getDueDates
     */
    public function test_get_due_dates_with_too_many_iterations()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('"10"');

        $calculator = new DueDateCalculator(10);

        $dueDates = $calculator->getDueDates(DueDateCalculator::TYPE_FUTURE, new Expression('0 0 1 1 1'), 1);

        $this->assertTrue(is_array($dueDates));
        $this->assertCount(0, $dueDates);
    }

    /**
     * @covers ::getPossibleDueDate
     */
    public function test_get_possible_due_date()
    {
        $calculator = new DueDateCalculator();

        $dueDate = $this->invokeMethod($calculator, 'getPossibleDueDate', [DueDateCalculator::TYPE_FUTURE, new \DateTime(), (new Expression('* * * * *'))->parse()]);
        $this->assertInstanceOf(\DateTime::class, $dueDate);
        $this->assertSame((new \DateTime())->modify('+ 1 minute')->format('Y-m-d H:i'), $dueDate->format('Y-m-d H:i'));

        $dueDate = $this->invokeMethod($calculator, 'getPossibleDueDate', [DueDateCalculator::TYPE_FUTURE, new \DateTime(), (new Expression('0 * * * *'))->parse()]);
        $this->assertInstanceOf(\DateTime::class, $dueDate);
        $this->assertSame((new \DateTime())->modify('+ 1 hour')->format('Y-m-d H:00'), $dueDate->format('Y-m-d H:i'));

        $dueDate = $this->invokeMethod($calculator, 'getPossibleDueDate', [DueDateCalculator::TYPE_FUTURE, new \DateTime(), (new Expression('0 0 * * *'))->parse()]);
        $this->assertInstanceOf(\DateTime::class, $dueDate);
        $this->assertSame((new \DateTime())->modify('+ 1 day')->format('Y-m-d 00:00'), $dueDate->format('Y-m-d H:i'));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('"test"');
        $this->invokeMethod($calculator, 'getPossibleDueDate', ['test', new \DateTime(), (new Expression('* * * * *'))->parse()]);
    }
}
