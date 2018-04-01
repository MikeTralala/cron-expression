<?php

namespace Tests\MikeTralala\CronExpression\Expression;

use MikeTralala\CronExpression\Exception\ExpressionException;
use MikeTralala\CronExpression\Expression\Expression;
use MikeTralala\CronExpression\Expression\Range;
use PHPUnit\Framework\TestCase;
use Tests\MikeTralala\Utility\InvokableMethodTrait;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\Expression
 */
class ExpressionTest extends TestCase
{
    use InvokableMethodTrait;

    /**
     * @covers ::__construct
     * @covers ::__toString
     */
    public function test_construct()
    {
        $expression = new Expression('* * * * *');

        $this->assertEquals('* * * * *', $expression);
    }

    /**
     * @covers ::parse
     */
    public function test_parse()
    {
        $expression = new Expression('1 1 1 1 1');

        $parsed = $expression->parse();

        $this->assertArrayHasKey('minute', $parsed);
        $this->assertArrayHasKey('hour', $parsed);
        $this->assertArrayHasKey('day_of_month', $parsed);
        $this->assertArrayHasKey('month', $parsed);
        $this->assertArrayHasKey('day_of_week', $parsed);

        $this->assertEquals('1 1 1 1 1', $expression);
    }

    /**
     * @covers ::parse
     */
    public function test_parse_with_addition_value()
    {
        $this->expectException(ExpressionException::class);
        $this->expectExceptionMessage('6');

        $expression = new Expression('1 1 1 1 1 1');

        $expression->parse();
    }

    /**
     * @covers ::parse
     */
    public function test_parse_with_invalid_value()
    {
        $this->expectException(ExpressionException::class);
        $this->expectExceptionMessage('"12345"');

        $expression = new Expression('12345 1 1 1 1');

        $expression->parse();
    }

    /**
     * @covers ::isDue
     */
    public function test_is_due()
    {
        $expression = new Expression('* * * * *');

        $this->assertEquals('* * * * *', $expression);
        $this->assertTrue($expression->isDue(new \DateTime()));
        $this->assertTrue($expression->isDue());

        $expression = new Expression('10 * * * *');

        $this->assertEquals('10 * * * *', $expression);
        $this->assertFalse($expression->isDue(\DateTime::createFromFormat('Y-m-d H:i', '2000-01-01 01:00')));
    }

    /**
     * @covers ::getNameForPosition
     */
    public function test_get_name_for_position()
    {
        $expression = new Expression('* * * * *');

        $this->assertSame('minute', $this->invokeMethod($expression, 'getNameForPosition', [0]));
        $this->assertSame('hour', $this->invokeMethod($expression, 'getNameForPosition', [1]));
        $this->assertSame('day_of_month', $this->invokeMethod($expression, 'getNameForPosition', [2]));
        $this->assertSame('month', $this->invokeMethod($expression, 'getNameForPosition', [3]));
        $this->assertSame('day_of_week', $this->invokeMethod($expression, 'getNameForPosition', [4]));

        $this->expectException(ExpressionException::class);
        $this->invokeMethod($expression, 'getNameForPosition', [5]);
    }

    /**
     * @covers ::getAllowedRange
     */
    public function test_get_allowed_range()
    {
        $expression = new Expression('* * * * *');

        $range = $this->invokeMethod($expression, 'getAllowedRange', [0]);
        $this->assertInstanceOf(Range::class, $range);
        $this->assertEquals(range(0, 59), $range->getRange());

        $range = $this->invokeMethod($expression, 'getAllowedRange', [1]);
        $this->assertInstanceOf(Range::class, $range);
        $this->assertEquals(range(0, 23), $range->getRange());

        $range = $this->invokeMethod($expression, 'getAllowedRange', [2]);
        $this->assertInstanceOf(Range::class, $range);
        $this->assertEquals(range(1, 31), $range->getRange());

        $range = $this->invokeMethod($expression, 'getAllowedRange', [3]);
        $this->assertInstanceOf(Range::class, $range);
        $this->assertEquals(range(1, 12), $range->getRange());

        $range = $this->invokeMethod($expression, 'getAllowedRange', [4]);
        $this->assertInstanceOf(Range::class, $range);
        $this->assertEquals(range(0, 6), $range->getRange());

        $this->expectException(ExpressionException::class);
        $this->invokeMethod($expression, 'getAllowedRange', [5]);
    }
}
