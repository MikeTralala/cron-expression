<?php

namespace Miketralala\CronExpression\Expression\Parser;

class RangeParser implements ParserInterface
{
    const DELIMITER = '-';

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
        if (self::WILDCARD === $chunk) {
            return $this->range->getRange();
        }

        list($start, $end) = array_map('intval', explode(self::DELIMITER, $chunk));

        return range($start, $end);
    }

    /**
     * {@inheritdoc}
     */
    public function satisfies($chunk)
    {
        if (!preg_match("/^(\*|\d{1,2}-\d{1,2})$/", $chunk)) {
            return false;
        }

        $values = $this->parse($chunk);

        foreach ($values as $value) {
            if (!$this->range->has($value)) {
                return false;
            }
        }

        return true;
    }
}
