<?php

namespace Miketralala\CronExpression\Expression\Parser;

class MultiDigitParser implements ParserInterface
{
    const DELIMITER = ',';

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
        $list = explode(self::DELIMITER, $chunk);

        $parsers[] = new StepParser($this->range);
        $parsers[] = new RangeParser($this->range);

        $values = [];
        foreach ($list as $item) {
            foreach ($parsers as $parser) {
                if (! $parser->satisfies($item)) {
                    continue;
                }

                $values = array_merge($values, $parser->parse($item));
            }

            $values[] = (int) $item;
        }

        $values = array_map('intval', array_unique($values));

        sort($values);

        return $values;
    }

    /**
     * {@inheritdoc}
     */
    public function satisfies($chunk)
    {
        if (false === strpos($chunk, self::DELIMITER)) {
            return false;
        }

        foreach ($this->parse($chunk) as $part) {
            if (! $this->range->has($part)) {
                return false;
            }
        }

        return true;
    }
}
