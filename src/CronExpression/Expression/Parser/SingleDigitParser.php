<?php

namespace Miketralala\CronExpression\Expression\Parser;

class SingleDigitParser implements ParserInterface
{
    /**
     * @var Range
     */
    private $range;

    /**
     * {@inheritdoc}
     */
    public function __construct(Range $range)
    {
        $this->range = $range;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($chunk)
    {
        return [(int) $chunk];
    }

    /**
     * {@inheritdoc}
     */
    public function satisfies($chunk)
    {
        return preg_match("/^\d{1,2}$/", $chunk) && $this->range->has($chunk);
    }
}
