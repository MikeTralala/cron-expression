<?php

namespace Miketralala\CronExpression\Expression\Parser;

class Parser implements ParserInterface
{
    /**
     * @var Range
     */
    private $range;

    /**
     * @var ParserInterface[]
     */
    private $childParsers;

    /**
     * {@inheritdoc}
     */
    public function __construct(Range $range)
    {
        $this->range = $range;

        $this->childParsers = [
            new MultiDigitParser($range),
            new RangeParser($range),
            new StepParser($range),
            new SingleDigitParser($range),
        ];
    }

    /**
     * @param string $chunk
     *
     * @return array
     */
    public function parse($chunk)
    {
        foreach ($this->childParsers as $parser) {
            if ($parser->satisfies($chunk)) {
                return $parser->parse($chunk);
            }
        }

        return [];
    }

    /**
     * @param string $chunk
     *
     * @return int
     */
    public function satisfies($chunk)
    {
        foreach ($this->childParsers as $parser) {
            if ($parser->satisfies($chunk)) {
                return true;
            }
        }

        return false;
    }
}
