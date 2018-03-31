<?php

namespace Tests\MikeTralala\CronExpression\Expression;

use MikeTralala\CronExpression\Expression\Range;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\Range
 */
class RangeTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $range = new Range(0, 59);

        $this->assertInstanceOf(Range::class, $range);
    }

    /**
     * @covers ::getStart
     */
    public function test_get_start()
    {
        $range = new Range(0, 59);

        $this->assertSame(0, $range->getStart());
    }

    /**
     * @covers ::getEnd
     */
    public function test_get_end()
    {
        $range = new Range(0, 59);

        $this->assertSame(59, $range->getEnd());
    }

    /**
     * @covers ::getRange
     */
    public function test_get_range()
    {
        $range = new Range(0, 59);

        $this->assertSame(range(0, 59), $range->getRange());
    }

    /**
     * @covers ::has
     */
    public function test_has()
    {
        $range = new Range(0, 59);

        foreach (range(0, 59) as $value) {
            $this->assertTrue($range->has($value));
        }
    }
}
