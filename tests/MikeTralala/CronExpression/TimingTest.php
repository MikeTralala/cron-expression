<?php

namespace Tests\MikeTralala\CronExpression;

use MikeTralala\CronExpression\Expression\Expression;
use MikeTralala\CronExpression\Timing;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Timing
 */
class TimingTest extends TestCase
{
    /**
     * @covers ::create
     * @covers ::__construct
     */
    public function test_create()
    {
        $timing = Timing::create();

        $this->assertInstanceOf(Timing::class, $timing);
        $this->assertEquals('* * * * *', $timing->getExpression());
    }

    /**
     * @covers ::everyMinute
     * @covers ::__construct
     */
    public function test_every_minute()
    {
        $timing = Timing::everyMinute();

        $this->assertInstanceOf(Timing::class, $timing);
        $this->assertEquals('* * * * *', $timing->getExpression());
    }

    /**
     * @covers ::everyHour
     * @covers ::__construct
     */
    public function test_every_hour()
    {
        $timing = Timing::everyHour();

        $this->assertInstanceOf(Timing::class, $timing);
        $this->assertEquals('0 * * * *', $timing->getExpression());
    }

    /**
     * @covers ::everyDay
     * @covers ::__construct
     */
    public function test_every_day()
    {
        $timing = Timing::everyDay();

        $this->assertInstanceOf(Timing::class, $timing);
        $this->assertEquals('0 0 * * *', $timing->getExpression());
    }

    /**
     * @covers ::getExpression
     */
    public function test_get_expression()
    {
        $timing = Timing::create();

        $expression = $timing->getExpression();
        $this->assertInstanceOf(Expression::class, $expression);
        $this->assertEquals('* * * * *', $expression);
    }

    /**
     * @covers ::isDue
     */
    public function test_is_due()
    {
        $timing = Timing::create();

        $this->assertEquals('* * * * *', $timing->getExpression());
        $this->assertTrue($timing->isDue(new \DateTime()));
    }
}
