<?php

namespace MikeTralala\CronExpression;

use MikeTralala\CronExpression\Expression\Expression;

class Timing
{
    /**
     * @var string
     */
    private $minute;
    /**
     * @var string
     */
    private $hour;
    /**
     * @var string
     */
    private $dayOfMonth;
    /**
     * @var string
     */
    private $month;
    /**
     * @var string
     */
    private $dayOfWeek;

    /**
     * Timing constructor.
     *
     * @param string $minute
     * @param string $hour
     * @param string $dayOfMonth
     * @param string $month
     * @param string $dayOfWeek
     */
    private function __construct($minute = '*', $hour = '*', $dayOfMonth = '*', $month = '*', $dayOfWeek = '*')
    {
        $this->minute     = $minute;
        $this->hour       = $hour;
        $this->dayOfMonth = $dayOfMonth;
        $this->month      = $month;
        $this->dayOfWeek  = $dayOfWeek;
    }

    /**
     * @param string $minute
     * @param string $hour
     * @param string $dayOfMonth
     * @param string $month
     * @param string $dayOfWeek
     *
     * @return Timing
     */
    public static function create($minute = '*', $hour = '*', $dayOfMonth = '*', $month = '*', $dayOfWeek = '*')
    {
        return new self($minute, $hour, $dayOfMonth, $month, $dayOfWeek);
    }

    /**
     * @return Timing
     */
    public static function everyMinute()
    {
        return new self();
    }

    /**
     * @return Timing
     */
    public static function everyHour()
    {
        return new self('0');
    }

    /**
     * @return Timing
     */
    public static function everyDay()
    {
        return new self('0', '0');
    }

    /**
     * @return Expression
     */
    public function getExpression()
    {
        return new Expression(sprintf('%s %s %s %s %s', $this->minute, $this->hour, $this->dayOfMonth, $this->month, $this->dayOfWeek));
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function isDue(\DateTime $dateTime)
    {
        $expression = $this->getExpression();

        return $expression->isDue($dateTime);
    }
}
