<?php

namespace MikeTralala\CronExpression\Expression;

class Range
{
    /**
     * @var int
     */
    private $start;

    /**
     * @var int
     */
    private $end;

    /**
     * @var array
     */
    private $range;

    /**
     * Range constructor.
     *
     * @param int $start
     * @param int $end
     */
    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end   = $end;
        $this->range = range($start, $end);
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return array
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param string|int $value
     *
     * @return bool
     */
    public function has($value)
    {
        return in_array((int) $value, $this->range, true);
    }
}
