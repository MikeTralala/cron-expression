<?php

namespace MikeTralala\CronExpression\Expression\Parser;

use MikeTralala\CronExpression\Expression\Range;

class RangeStepParser implements ParserInterface
{
    /**
     * @var Range
     */
    private $range;

    /**
     * ParserInterface constructor.
     *
     * @param Range $range
     */
    public function __construct(Range $range)
    {
        $this->range = $range;
    }

    /**
     * @param string $chunk
     *
     * @return array
     */
    public function parse($chunk)
    {
        list($rangeChunk, $step) = explode('/', $chunk);

        $subParser = new RangeParser($this->range);
        $subValues = $subParser->parse($rangeChunk);

        $values = [];
        foreach ($subValues as $subValue) {
            if (0 === $subValue % (int) $step) {
                $values[] = $subValue;
            }
        }

        return $values;
    }

    /**
     *
     *
     * @param string $chunk
     *
     * @return int
     */
    public function satisfies($chunk)
    {
        return 0 !== preg_match("/^\d{1,2}-\d{1,2}\/\d{1,2}$/", $chunk);
    }
}
