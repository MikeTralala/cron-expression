<?php

namespace Tests\MikeTralala\CronExpression\Expression\Parser;

use MikeTralala\CronExpression\Expression\Parser\RangeStepParser;
use MikeTralala\CronExpression\Expression\Range;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\Parser\RangeStepParser
 */
class RangeStepParserTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $parser = new RangeStepParser(new Range(0, 59));

        $this->assertInstanceOf(RangeStepParser::class, $parser);
    }

    /**
     * @covers ::parse
     */
    public function test_parse()
    {
        $parser = new RangeStepParser(new Range(0, 59));

        $this->assertEquals([0, 15, 30, 45], $parser->parse('0-45/15'));
    }

    /**
     * @covers ::satisfies
     */
    public function test_satisfies()
    {
        $parser = new RangeStepParser(new Range(0, 59));

        $this->assertTrue($parser->satisfies('0-45/15'));

        $this->assertFalse($parser->satisfies('*'));
        $this->assertFalse($parser->satisfies('0-45'));
        $this->assertFalse($parser->satisfies('*/2'));
        $this->assertFalse($parser->satisfies('1'));
        $this->assertFalse($parser->satisfies('60'));
    }
}
