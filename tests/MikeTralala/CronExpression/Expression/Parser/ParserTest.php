<?php

namespace Tests\MikeTralala\CronExpression\Expression\Parser;

use MikeTralala\CronExpression\Expression\Parser\Parser;
use MikeTralala\CronExpression\Expression\Range;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Expression\Parser\Parser
 */
class ParserTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $parser = new Parser(new Range(0, 59));

        $this->assertInstanceOf(Parser::class, $parser);
    }

    /**
     * @covers ::parse
     */
    public function test_parse()
    {
        $parser = new Parser(new Range(0, 59));

        $this->assertEquals([0, 15, 30, 45], $parser->parse('0-45/15'));
        $this->assertEquals(range(0, 59), $parser->parse('*'));
        $this->assertEquals(range(10, 15), $parser->parse('10-15'));
        $this->assertEquals(range(1, 5), $parser->parse('1,2,3,4,5'));
        $this->assertEquals([1, 2, 3, 4, 5, 15, 25, 35, 45, 55], $parser->parse('1,2,3,4,5/10'));
        $this->assertEquals([1, 2, 3, 4, 5, 6, 15, 25, 35, 45, 55], $parser->parse('6,1-5,5/10'));
        $this->assertEquals([], $parser->parse('60'));
    }

    /**
     * @covers ::satisfies
     */
    public function test_satisfies()
    {
        $parser = new Parser(new Range(0, 59));

        $this->assertTrue($parser->satisfies('*'));
        $this->assertTrue($parser->satisfies('10-50'));
        $this->assertTrue($parser->satisfies('*/2'));
        $this->assertTrue($parser->satisfies('1'));

        $this->assertFalse($parser->satisfies('60'));
    }
}
