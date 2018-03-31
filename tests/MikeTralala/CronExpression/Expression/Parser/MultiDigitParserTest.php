<?php

namespace Tests\MikeTralala\CronExpression\Expression\Parser;

use MikeTralala\CronExpression\Expression\Parser\MultiDigitParser;
use MikeTralala\CronExpression\Expression\Range;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\Parser\MultiDigitParser
 */
class MultiDigitParserTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $parser = new MultiDigitParser(new Range(0, 59));

        $this->assertInstanceOf(MultiDigitParser::class, $parser);
    }

    /**
     * @covers ::parse
     */
    public function test_parse()
    {
        $parser = new MultiDigitParser(new Range(0, 59));

        $this->assertEquals(range(0, 59), $parser->parse('*'));
        $this->assertEquals(range(10, 15), $parser->parse('10-15'));
    }

    /**
     * @covers ::satisfies
     */
    public function test_satisfies()
    {
        $parser = new MultiDigitParser(new Range(0, 59));

        $this->assertTrue($parser->satisfies('*,1,2,3'));

        $this->assertFalse($parser->satisfies('10-50'));
        $this->assertFalse($parser->satisfies('*'));
        $this->assertFalse($parser->satisfies('*/2'));
        $this->assertFalse($parser->satisfies('1'));
        $this->assertFalse($parser->satisfies('60'));
    }
}
