<?php

namespace Miketralala\CronExpression\Expression\Parser;

class StepParser implements ParserInterface
{
    const DELIMITER = '/';

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
        list($start, $step) = explode(self::DELIMITER, $chunk);

        $values = [];

        if ($start === self::WILDCARD) {
            $start = '0';
        }

        $value = $start;

        $values[] = (int) $value;
        while ($value + $step < $this->range->getEnd()) {
            $value    = $value + $step;
            $values[] = (int) $value;
        }

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function satisfies($chunk)
    {
        if (! preg_match("/^(\*|\d{1,2})\/\d{1,2}$/", $chunk)) {
            return false;
        }

        $values = $this->parse($chunk);

        foreach ($values as $value) {
            if (! $this->range->has($value)) {
                return false;
            }
        }

        return true;
    }
}
