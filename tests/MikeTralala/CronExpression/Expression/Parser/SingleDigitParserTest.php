<?php

namespace Tests\MikeTralala\CronExpression\Expression\Parser;

use MikeTralala\CronExpression\Expression\Range;
use MikeTralala\CronExpression\Expression\Parser\SingleDigitParser;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\Parser\SingleDigitParser
 */
class SingleDigitParserTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $parser = new SingleDigitParser(new Range(0, 59));

        $this->assertInstanceOf(SingleDigitParser::class, $parser);
    }

    /**
     * @covers ::parse
     */
    public function test_parse()
    {
        $parser = new SingleDigitParser(new Range(0, 59));

        $this->assertEquals([1], $parser->parse('1'));
    }

    /**
     * @covers ::satisfies
     */
    public function test_satisfies()
    {
        $parser = new SingleDigitParser(new Range(0, 59));

        $this->assertTrue($parser->satisfies('1'));

        $this->assertFalse($parser->satisfies('*'));
        $this->assertFalse($parser->satisfies('*/1'));
        $this->assertFalse($parser->satisfies('10-50'));
        $this->assertFalse($parser->satisfies('60'));
    }
}
